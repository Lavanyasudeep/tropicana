<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Models\{ Role, Permission, RoleMenuPermission}; 
use App\Models\Master\General\{ Menu}; 

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Role::with('menuPermissions')->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('quick_search'))) {
                        $search = $request->get('quick_search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('role_name', 'LIKE', "%$search%")
                                ->orWhere('short_name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                       data-id='" . $res->role_id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.general.role.edit', $res->role_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.general.role.view', $res->role_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.general.role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::whereNull('parent_id')
                    ->with('children')
                    ->orderBy('sort_order')
                    ->get();
        $permissions = Permission::all();
        $assigned = [];
        return view('admin.master.general.role.form', compact('menus', 'permissions', 'assigned'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:cs_role,role_name',
            'role_desc' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'permissions' => 'nullable|array',
            'permissions.*' => 'array', 
            'permissions.*.*' => 'integer|exists:cs_permission,permission_id',
        ]);

        $role = Role::create([
            'role_name' => $validated['role_name'],
            'role_desc' => $validated['role_desc'] ?? null,
            'short_name' => $validated['short_name'] ?? null,
        ]);

        foreach ($request->input('permissions', []) as $menu_id => $permission_ids) {
            foreach ($permission_ids as $perm_id) {
                RoleMenuPermission::create([
                    'role_id' => $role->role_id,
                    'menu_id' => $menu_id,
                    'permission_id' => $perm_id,
                ]);
            }
        }

        return redirect()->route('admin.master.general.role.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $role = Role::findOrFail($id);

        // Get all menus and permissions
        $menus = Menu::whereNull('parent_id')
                    ->with('children')
                    ->orderBy('sort_order')
                    ->get();
        $permissions = Permission::all();

        // Format assigned permissions
        $assigned = RoleMenuPermission::where('role_id', $role->role_id)
            ->get()
            ->groupBy('menu_id')
            ->map(function ($items) {
                return $items->pluck('permission_id')->toArray();
            });

        // Build nested tree
        // $menuTree = $this->buildMenuTree($menus);

        return view('admin.master.general.role.view', compact(
                'role',
                'permissions',
                'assigned',
                'menus'
                // 'menuTree' // renamed for clarity
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $role = Role::findOrFail($id);
        
        $menus = Menu::whereNull('parent_id')
                    ->with('children')
                    ->orderBy('sort_order')
                    ->get();

        $permissions = Permission::all();

        // Group existing assigned permissions by menu_id for checkbox pre-check
        $assigned = $role->menuPermissions()
            ->get()
            ->groupBy('menu_id')
            ->map(fn($items) => $items->pluck('permission_id')->toArray())
            ->toArray();

        return view('admin.master.general.role.form', compact('role', 'menus', 'permissions', 'assigned'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $role = Role::findOrFail($id);

        // Step 1: Validate form input
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:cs_role,role_name,' . $role->role_id . ',role_id',
            'role_desc' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'permissions' => 'nullable|array',
            'permissions.*' => 'array',
            'permissions.*.*' => 'integer|exists:cs_permission,permission_id',
        ]);

        // Step 2: Update role
        $role->update([
            'role_name' => $validated['role_name'],
            'short_name' => $validated['short_name'] ?? null,
            'role_desc' => $validated['role_desc'] ?? null,
            'mobile_access' => $request->has('mobile_access') ? 1 : 0,
            'active' => $request->has('active') ? 1 : 0,
            'updated_by' => auth()->id(),
        ]);

        // Step 3: Replace permissions safely (delete + insert or upsert)
        RoleMenuPermission::where('role_id', $role->role_id)->delete();

        $newPermissions = [];
        foreach ($request->input('permissions', []) as $menu_id => $perm_ids) {
            foreach ($perm_ids as $perm_id) {
                $newPermissions[] = [
                    'role_id' => $role->role_id,
                    'menu_id' => $menu_id,
                    'permission_id' => $perm_id,
                ];
            }
        }

        // Step 4: Insert only if permissions exist
        if (!empty($newPermissions)) {
            // Ensures no duplicates even in edge case
            RoleMenuPermission::insertOrIgnore($newPermissions);
        }

        return redirect()->route('admin.master.general.role.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.master.general.role.index')->with('success', 'Role deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->active = !$role->active;
        $role->save();

        return response()->json(['success' => true, 'status' => $role->active]);
    }
}

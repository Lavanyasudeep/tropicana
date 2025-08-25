<?php

namespace App\Http\Controllers\Admin\Master\HR;

use App\Models\{ User, Role, Company, Branch, Department};
use App\Models\Master\HR\{ Employee};

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = User::with(['company', 'branch', 'employee.designation', 'role'])->select('*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('quick_search'))) {
                        $search = $request->get('quick_search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhereHas('company', function ($q2) use ($search) {
                                    $q2->where('company_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('branch', function ($q2) use ($search) {
                                    $q2->where('branch_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('employee', function ($q2) use ($search) {
                                    $q2->where('employee_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('role', function ($q2) use ($search) {
                                    $q2->where('role_name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('employee', function ($res) {
                    return '<img src="' . $res->employee->photo_url . '" alt="Logo" height="40">'.$res->employee->employee_name;
                })
                ->addColumn('mobile_number', function ($res) {
                    return $res->employee->mobile_number;
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                       data-id='" . $res->id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.hr.user.edit', $res->id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.hr.user.view', $res->id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions', 'employee'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.hr.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::select('company_id', 'company_name')->get();
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $employees = Employee::select('employee_id', DB::raw("CONCAT(first_name, ' ', last_name) as employee_name"))->get();
        $roles = Role::select('role_id', 'role_name')->get();

        return view('admin.master.hr.user.form', compact('companies', 'branches', 'employees', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'    => ['nullable', 'integer'],
            'branch_id'     => ['nullable', 'integer'],
            'warehouse_id'  => ['nullable', 'integer'],
            'employee_id'   => ['nullable', 'integer'],
            'role_id'       => ['required', 'integer'],
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'max:100', 'unique:cs_users,email'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'], // requires password_confirmation field
        ]);

        $user = new User();
        $user->fill($validated);
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('admin.master.hr.user.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['company', 'branch', 'employee.designation', 'role'])->findOrFail($id);

        return view('admin.master.hr.user.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $companies = Company::select('company_id', 'company_name')->get();
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $employees = Employee::select('employee_id', DB::raw("CONCAT(first_name, ' ', last_name) as emp_name"))->get();
        $roles = Role::select('role_id', 'role_name')->get();

        return view('admin.master.hr.user.form', compact('user', 'companies', 'branches', 'employees', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'company_id'    => ['nullable', 'integer'],
            'branch_id'     => ['nullable', 'integer'],
            'warehouse_id'  => ['nullable', 'integer'],
            'employee_id'   => ['nullable', 'integer'],
            'role_id'       => ['required', 'integer'],
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'max:100', Rule::unique('cs_users')->ignore($user->id)],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->fill($validated);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.master.hr.user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->active = !$company->active;
        $user->save();

        return response()->json(['success' => true, 'status' => $user->active]);
    }
}

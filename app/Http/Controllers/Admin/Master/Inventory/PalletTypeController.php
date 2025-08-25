<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Models\Master\Inventory\{ PalletType};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

class PalletTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = PalletType::all();

        if ($request->ajax()) {
            return DataTables::of($types)
                ->addColumn('is_active', function ($type) {
                    return '<button class="btn btn-sm toggle-status ' . ($type->is_active ? 'btn-success' : 'btn-secondary') . '" data-id="' . $type->product_type_id . '">' . ($type->is_active ? 'Active' : 'Inactive') . '</button>';
                })
                ->addColumn('actions', function ($type) {
                    return '
                        <button class="btn btn-sm btn-warning edit-btn" 
                            data-id="' . $type->pallet_type_id . '" 
                            data-type-name="' . $type->type_name . '" 
                            data-description="' . $type->description . '">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="' . route('admin.master.inventory.pallet-type.destroy', $type->pallet_type_id) . '" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['is_active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.inventory.pallet-type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        PalletType::create([
            'company_id' => auth()->user()->company_id,
            'branch_id' => auth()->user()->branch_id,
            'type_name' => $request->type_name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Pallet Type added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $type = PalletType::findOrFail($id);
        $type->update([
            'type_name' => $request->type_name,
            'description' => $request->description
        ]);
        return back()->with('success', 'Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PalletType::findOrFail($id)->delete();
        return back()->with('success', 'Deleted.');
    }

    public function toggleStatus(Request $request)
    {
        $type = PalletType::findOrFail($request->id);
        $type->active = !$type->active;
        $type->save();

        return response()->json(['success' => true, 'status' => $type->active]);
    }
}

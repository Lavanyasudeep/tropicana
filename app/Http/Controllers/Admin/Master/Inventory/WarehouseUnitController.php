<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Master\Inventory\WarehouseUnit;
use App\Models\Master\General\ProductType;

use Illuminate\Http\Request;
use DataTables;

class WarehouseUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productTypes = ProductType::get();

        $data = WarehouseUnit::with('productType')->select('cs_warehouse_unit.*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search')['value'] ?? '';
                        $instance->where(function($w) use($search){
                            $w->where('wu_no', 'LIKE', "%$search%")
                              ->orWhere('wu_name', 'LIKE', "%$search%")
                              ->orWhereHas('productType', function($q) use($search){
                                $q->where('type_name', 'LIKE', "%$search%");
                              });
                        });
                    }
                })
                ->addColumn('storage_product_type', function ($row) {
                    return $row->productType ? $row->productType->type_name : '';
                })
                ->editColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " 
                        . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->wu_id}'>" 
                        . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($unit) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-btn' 
                        data-id='{$unit->wu_id}'
                        data-wu_no='{$unit->wu_no}'
                        data-wu_name='{$unit->wu_name}'
                        data-temperature_range='{$unit->temperature_range}'
                        data-storage_product_type_id='{$unit->storage_product_type_id}'
                        data-no_of_docks='{$unit->no_of_docks}'
                        data-no_of_rooms='{$unit->no_of_rooms}'
                        data-status='{$unit->status}'
                        title='Edit'
                    ><i class='fas fa-edit'></i></button>";

                    $deleteForm = "<form action='" . route('admin.master.inventory.warehouse-unit.destroy', $unit->wu_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete'><i class='fas fa-trash'></i></button>
                    </form>";

                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['Status', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.inventory.warehouse-unit.index', compact('productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wu_no' => 'required|string|max:50|unique:cs_warehouse_unit,wu_no',
            'wu_name' => 'required|string|max:100',
            'temperature_range' => 'required|string|max:50',
            'storage_product_type_id' => 'required|integer|exists:cs_product_types,product_type_id',
            'no_of_docks' => 'nullable|integer|min:0',
            'no_of_rooms' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive,Maintenance'
        ]);

        $validated['is_active'] = $validated['status'] === 'Active' ? 1 : 0;

        WarehouseUnit::create($validated);

        return redirect()->route('admin.master.inventory.warehouse-unit.index')
            ->with('success', 'Warehouse Unit Created Successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'wu_no' => 'required|string|max:50|unique:cs_warehouse_unit,wu_no,' . $id . ',wu_id',
            'wu_name' => 'required|string|max:100',
            'temperature_range' => 'required|string|max:50',
            'storage_product_type_id' => 'required|integer|exists:cs_product_types,product_type_id',
            'no_of_docks' => 'nullable|integer|min:0',
            'no_of_rooms' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive,Maintenance'
        ]);

        $validated['is_active'] = $validated['status'] === 'Active' ? 1 : 0;

        $unit = WarehouseUnit::findOrFail($id);
        $unit->update($validated);

        return redirect()->route('admin.master.inventory.warehouse-unit.index')
            ->with('success', 'Warehouse Unit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = WarehouseUnit::findOrFail($id);
        $unit->delete();

        return redirect()->route('admin.master.inventory.warehouse-unit.index')
            ->with('success', 'Warehouse Unit deleted successfully!');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(Request $request)
    {
        $unit = WarehouseUnit::findOrFail($request->id);
        $unit->is_active = !$unit->is_active;
        $unit->save();

        return response()->json(['success' => true, 'status' => $unit->is_active]);
    }
}

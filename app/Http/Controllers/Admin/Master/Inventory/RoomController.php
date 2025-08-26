<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\WarehouseUnit;
use App\Models\Master\General\ProductType;
use Illuminate\Http\Request;
use DataTables;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storageRooms = StorageRoom::active()->get();
        $warehouseUnits = WarehouseUnit::all();
        $productTypes = ProductType::all();

        $data = StorageRoom::select('cs_storage_rooms.*')
                            ->with(['warehouseUnit:wu_id,wu_name', 'productType:product_type_id,type_name']);

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('warehouse_unit', function ($res) {
                    return $res->warehouseUnit ? $res->warehouseUnit->wu_name : '-';
                })
                ->addColumn('product_type', function ($res) {
                    return $res->productType ? $res->productType->name : '-';
                })
                ->editColumn('Status', function ($res) {
                    return "<span class='badge badge-" . 
                        ($res->status === 'Active' ? 'success' : ($res->status === 'Maintenance' ? 'warning' : 'secondary')) . 
                        "'>{$res->status}</span>";
                })
                ->editColumn('is_active', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . 
                        ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->room_id}'>" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";
                    return $statusToggle;
                })
                ->addColumn('actions', function ($room) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-btn' 
                        data-id='{$room->room_id}'
                        data-warehouse_unit_id='{$room->warehouse_unit_id}'
                        data-room_no='{$room->room_no}'
                        data-name='{$room->name}'
                        data-description='{$room->description}'
                        data-capacity='{$room->total_capacity}'
                        data-temperature='{$room->temperature_range}'
                        data-product_type_id='{$room->storage_product_type_id}'
                        data-status='{$room->status}'
                        data-is_active='{$room->is_active}'
                        title='Edit'><i class='fas fa-edit'></i></button>";

                    $deleteForm = "<form action='" . route('admin.master.inventory.rooms.destroy', $room->room_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete'><i class='fas fa-trash'></i></button>
                    </form>";

                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['Status', 'is_active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.inventory.rooms.index', compact('storageRooms', 'warehouseUnits', 'productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_unit_id' => 'required|integer|exists:cs_warehouse_unit,wu_id',
            'room_no' => 'required|string|max:20|unique:cs_storage_rooms,room_no',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'total_capacity' => 'required|numeric',
            'temperature_range' => 'required|string|max:50',
            'storage_product_type_id' => 'required|integer|exists:cs_product_types,product_type_id',
            'status' => 'required|in:Active,Inactive,Maintenance',
            'is_active' => 'required|boolean'
        ]);

        StorageRoom::create($validated);

        return redirect()->route('admin.master.inventory.rooms.index')->with('success', 'Storage Room Created Successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'warehouse_unit_id' => 'required|integer|exists:cs_warehouse_unit,wu_id',
            'room_no' => 'required|string|max:20|unique:cs_storage_rooms,room_no,' . $id . ',room_id',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'total_capacity' => 'required|numeric',
            'temperature_range' => 'required|string|max:50',
            'storage_product_type_id' => 'required|integer|exists:cs_product_types,product_type_id',
            'status' => 'required|in:Active,Inactive,Maintenance',
            'is_active' => 'required|boolean'
        ]);

        $room = StorageRoom::findOrFail($id);
        $room->update($validated);

        return redirect()->route('admin.master.inventory.rooms.index')->with('success', 'Storage Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = StorageRoom::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.master.inventory.rooms.index')->with('success', 'Storage room deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $room = StorageRoom::findOrFail($request->id);
        $room->is_active = !$room->is_active;
        $room->save();

        return response()->json(['success' => true, 'status' => $room->is_active]);
    }
}

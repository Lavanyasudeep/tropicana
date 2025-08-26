<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Master\Inventory\Docks;
use App\Models\Master\Inventory\WarehouseUnit;

use Yajra\DataTables\Facades\DataTables;

class DockController extends Controller
{
    /**
     * Display a listing of docks.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Docks::with('warehouseUnit')->select('cs_docks.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('warehouse_unit', function ($row) {
                    return $row->warehouseUnit->wu_name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status === 'Active' ? 'btn-success' : 'btn-secondary';
                    return '<button class="btn btn-sm toggle-status '.$btnClass.'" data-id="'.$row->dock_id.'">'.$row->status.'</button>';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <button class="btn btn-warning btn-sm edit-btn"
                            data-id="'.$row->dock_id.'"
                            data-dock_no="'.$row->dock_no.'"
                            data-dock_name="'.$row->dock_name.'"
                            data-warehouse_unit_id="'.$row->warehouse_unit_id.'"
                            data-vehicle_type="'.$row->vehicle_type.'"
                            data-status="'.$row->status.'">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="'.$row->dock_id.'">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        $warehouseUnits = WarehouseUnit::all();
        return view('admin.master.inventory.docks.index', compact('warehouseUnits'));
    }

    /**
     * Store a newly created dock.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dock_no' => 'required|string|max:20|unique:dock_master,dock_no',
            'dock_name' => 'required|string|max:100',
            'warehouse_unit_id' => 'required|exists:warehouse_units,wu_id',
            'dock_type' => 'required|in:Loading,Receiving,Multi-purpose',
            'vehicle_type' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive,Maintenance'
        ]);

        DockMaster::create($request->only([
            'dock_no', 'dock_name', 'warehouse_unit_id', 'dock_type', 'vehicle_type', 'status'
        ]));

        return response()->json(['success' => true, 'message' => 'Dock created successfully.']);
    }

    /**
     * Update the specified dock.
     */
    public function update(Request $request, $id)
    {
        $dock = DockMaster::findOrFail($id);

        $request->validate([
            'dock_no' => 'required|string|max:20|unique:dock_master,dock_no,'.$dock->dock_id.',dock_id',
            'dock_name' => 'required|string|max:100',
            'warehouse_unit_id' => 'required|exists:warehouse_units,wu_id',
            'dock_type' => 'required|in:Loading,Receiving,Multi-purpose',
            'vehicle_type' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive,Maintenance'
        ]);

        $dock->update($request->only([
            'dock_no', 'dock_name', 'warehouse_unit_id', 'dock_type', 'vehicle_type', 'status'
        ]));

        return response()->json(['success' => true, 'message' => 'Dock updated successfully.']);
    }

    /**
     * Toggle dock status.
     */
    public function toggleStatus(Request $request)
    {
        $dock = DockMaster::findOrFail($request->id);
        $dock->status = $dock->status === 'Active' ? 'Inactive' : 'Active';
        $dock->save();

        return response()->json(['success' => true, 'status' => $dock->status]);
    }

    /**
     * Remove the specified dock.
     */
    public function destroy($id)
    {
        $dock = DockMaster::findOrFail($id);
        $dock->delete();

        return response()->json(['success' => true, 'message' => 'Dock deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Block;
use App\Models\Master\Inventory\WarehouseUnit;

use Illuminate\Http\Request;

use DataTables;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rooms= StorageRoom::active()->get();
        $warehouseUnits = WarehouseUnit::all();

        $data = Block::with(['room', 'warehouseUnit'])
                    ->select('cs_blocks.*');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('ApprovalStatus') != '') {
                    //     $instance->where('ApprovalStatus', $request->get('ApprovalStatus'));
                    // }
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('name', 'LIKE', "%$search%")
                              ->orWhere('description', 'LIKE', "%$search%"); 
                        });
                    }
                })
                ->addColumn('warehouse_unit', function ($row) {
                    return $row->warehouseUnit->wu_name ?? '-';
                })
                ->addColumn('room_name', function ($row) {
                    return $row->room ? $row->room->name : 'No Room';
                })
                ->editColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->block_id}'>" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($block) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-btn ' 
                        data-id='{$block->block_id}'
                        data-name='{$block->name}'
                        data-block-no='{$block->block_no}'
                        data-unit-id='{$block->warehouse_unit_id}'
                        data-room-id='{$block->room_id}'
                        data-description='{$block->description}'
                        data-capacity='{$block->total_capacity}'
                        data-temperature='{$block->temperature_range}'
                        title='Edit'
                    ><i class='fas fa-edit' ></i></button>";
        
                    $deleteForm = "<form action='" . route('admin.master.inventory.blocks.destroy', $block->block_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete' ><i class='fas fa-trash' ></i></button>
                    </form>";
        
                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['Status', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.inventory.block.index', compact('rooms', 'warehouseUnits'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            // 'total_capacity' => 'required|numeric',
            // 'temperature_range' => 'required|string',
        ]);

        Block::create([
            'name' => $request->name,
            'warehouse_unit_id' => $request->warehouse_unit_id,
            'room_id' => $request->room_id,
            'block_no' => $request->block_no,
            'description' => $request->description,
            'total_capacity' => $request->total_capacity,
            'temperature_range' => $request->temperature_range
        ]);

        return redirect()->route('admin.master.inventory.blocks.index')->with('success', 'Block Created Successfully!');
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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            // 'total_capacity' => 'required|numeric',
            // 'temperature_range' => 'required|string',
        ]);
    
        $block = Block::findOrFail($id);
        $block->fill($request->only([
            'block_no',
            'name',
            'warehouse_unit_id',
            'room_id',
            'description',
            'total_capacity',
            'max_weight',
            'temperature_range',
            'status'
        ]));

        $block->save();
    
        return redirect()->route('admin.master.inventory.blocks.index')->with('success', 'Block updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $block = Block::findOrFail($id);
        $block->delete();

        return redirect()->route('admin.master.inventory.blocks.index')->with('success', 'Block deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $block = Block::findOrFail($request->id);
        $block->is_active = !$block->is_active;
        $block->save();

        return response()->json(['success' => true, 'status' => $block->is_active]);
    }

}

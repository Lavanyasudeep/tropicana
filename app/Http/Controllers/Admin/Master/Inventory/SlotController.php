<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use App\Models\StorageUnit;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\General\Unit;
use App\Models\Master\Inventory\Pallet;
use App\Models\Master\Inventory\PalletType;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Slot;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;


class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storageRooms = StorageRoom::with('racks.slots')->get();
        $units = Unit::active()->get();
        $racks = Rack::active()->get();
        $palletTypes = PalletType::active()->get();

        $data = Slot::with('rack')
                    ->select('cs_slots.*');
        
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
                            $w->where('slot_no', 'LIKE', "%$search%")
                              ->orWhereHas('room', function($q) use($search){
                                $q->where('name', 'LIKE', "%$search%");
                              })
                              ->orWhereHas('rack', function($q) use($search){
                                $q->where('name', 'LIKE', "%$search%");
                              });
                        });
                    }
                })
                ->addColumn('storage_room_name', function ($row) {
                    return $row->room ? $row->room->name : 'No Room';
                })
                ->addColumn('rack_name', function ($row) {
                    return $row->rack ? $row->rack->name : 'No Rack';
                })
                ->addColumn('pallet_type', function ($row) {
                    return $row->palletType ? $row->palletType->type_name : 'Nil';
                })
                ->editColumn('active', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->slot_id}'>" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('slot_status', function ($res) {
                    $status = $res->getSlotStatus();
                    $batteryIcon = $status['battery_icon'];
                    $batteryColor = $status['battery_color'];
                    $capacityUsed = $status['capacity_used'];
                    $capacityTotal = $status['capacity_total'];
                    $percent = $status['percent'];

                    return '
                        <div class="pallet-status-wrapper" style="position: relative; display: inline-block; text-align: center;">
                            <div class="pallet-percent" style="position: absolute; right: -31px; top: 31%; transform: translateY(-50%); font-size: 12px; font-weight: bold; color: #000;">
                                ' . number_format($percent, 0) . '%
                            </div>
                            <div class="battery-icon" style="display: flex; flex-direction: column; align-items: center;">
                                <i class="fas ' . $batteryIcon . ' ' . $batteryColor . ' fa-2x" data-toggle="tooltip" title="Used: ' . $capacityUsed . '/' . $capacityTotal . ' (' . number_format($percent, 0) . '%)"></i>
                                <div class="capacity-text" style="font-size: 12px; color: #555;">
                                    ' . $capacityUsed . '/' . $capacityTotal . '
                                </div>
                            </div>
                        </div>';
                })
                ->addColumn('actions', function ($res) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-slot-btn' 
                        data-id='{$res->slot_id}'
                        data-no='{$res->slot_no}'
                        data-name='{$res->name}'
                        data-roomid='{$res->room_id}'
                        data-rackid='{$res->rack_id}'
                        data-capacity='{$res->capacity}'
                        data-level-no='{$res->level_no}'
                        data-depth-no='{$res->depth_no}'
                        data-status='{$res->status}'
                        title='Edit'
                    ><i class='fas fa-edit' ></i></button>";
        
                    $deleteForm = "<form action='" . route('admin.master.inventory.slots.destroy', $res->slot_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete' ><i class='fas fa-trash' ></i></button>
                    </form>";
        
                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['slot_status','active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }
        
        return view('admin.master.inventory.slots.index', compact('storageRooms', 'racks', 'units', 'palletTypes'));
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
            'room_id' => 'required',
            'name' => 'required|string',
            'slot_no' => 'required',
            // 'capacity' => 'required|numeric',
            // 'position' => 'required',
        ]);

        Slot::create([
            'room_id' => $request->room_id,
            'rack_id' => $request->rack_id,
            'name' => $request->name,
            'slot_no' => $request->slot_no,
            'pallet_type_id' => $request->pallet_type_id,
            'capacity' => $request->capacity,
            'level_no' => $request->level_no,
            'depth_no' => $request->depth_no,
        ]);

        return redirect()->route('admin.master.inventory.slots.index')->with('success', 'Slot added successfully!');
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
            'room_id' => 'required',
            'name' => 'required|string',
            'slot_no' => 'required',
            // 'capacity' => 'required|numeric',
            // 'position' => 'required',
        ]);
    
        $slot = Slot::findOrFail($id);
        $slot->fill($request->only([
            'slot_no',
            'name',
            'room_id',
            'rack_id',
            'pallet_type_id',
            'capacity',
            'level_no',
            'depth_no',
            'status'
        ]));
        
        $slot->save();
    
        return redirect()->route('admin.master.inventory.slots.index')->with('success', 'Slot updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slot = Slot::findOrFail($id);
        $slot->delete();

        return redirect()->route('admin.master.inventory.slots.index')->with('success', 'Slot deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $slot = Slot::findOrFail($request->id);
        $slot->is_active = !$slot->is_active;
        $slot->save();

        return response()->json(['success' => true, 'status' => $slot->is_active]);
    }

    // Fetch available slots in a selected rack
    public function getSlots(Request $request)
    {
        $slots = Slot::whereHas('rack', function ($query) use ($request) {
                        $query->where('room_id', $request->room_id)
                            ->where('rack_id', $request->rack_id);
                        })
                        ->where('status', 'empty')
                        ->get();

        return response()->json(['slots' => $slots]);
    }

    // Fetch slot detail in a selected slot
    public function getSlotDetail(Request $request)
    {
        $slot = Slot::with(['pallet.stocks.product', 'pallet.palletType'])->findOrFail($request->slot_id);

        return response()->json(['slot' => $slot]);
    }
}

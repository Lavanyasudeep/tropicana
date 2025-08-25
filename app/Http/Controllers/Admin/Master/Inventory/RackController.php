<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Block;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Pallet;
use App\Models\Master\Inventory\Slot;

use Illuminate\Http\Request;

use DataTables;


class RackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storageRooms = StorageRoom::with('racks')->get();
        $blocks = Block::active()->get();

        $data = Rack::with(['room', 'block'])
                    ->select(['rack_id', 'block_id', 'rack_no', 'name', 'room_id', 'capacity', 'position_x', 'position_y', 'no_of_levels', 'no_of_depth', 'is_active as Status']);
        
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
                              ->orWhere('rack_no', 'LIKE', "%$search%")
                              ->orWhereHas('room', function($q) use($search){
                                $q->where('name', 'LIKE', "%$search%");
                              }); 
                        });
                    }
                })
                ->addColumn('storage_room_name', function ($row) {
                    return $row->room ? $row->room->name : 'No Room';
                })
                ->addColumn('block_name', function ($row) {
                    return $row->block ? $row->block->name : 'No Block';
                })
                ->editColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->rack_id}'>" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-rack-btn' 
                        data-id='{$res->rack_id}'
                        data-no='{$res->rack_no}'
                        data-name='{$res->name}'
                        data-roomid='{$res->room_id}'
                        data-blockid='{$res->block_id}'
                        data-capacity='{$res->capacity}'
                        data-no-of-levels='{$res->no_of_levels}'
                        data-no-of-depth='{$res->no_of_depth}'
                        data-positionx='{$res->position_x}'
                        data-positiony='{$res->position_y}'
                        title='Edit'
                    ><i class='fas fa-edit' ></i></button>";
        
                    $deleteForm = "<form action='" . route('admin.master.inventory.racks.destroy', $res->room_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete' ><i class='fas fa-trash' ></i></button>
                    </form>";

                    // $generatePalletBtn = "<button class='btn btn-info btn-sm generate-pallets-btn " . 
                    //                 ($res->all_pallets_exist ? 'disabled' : '') . "' 
                    //                 data-id='{$res->rack_id}'
                    //                 title='Auto Generate Pallets'
                    //             ><i class='fas fa-cogs'></i></button>";
        
                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['Status', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }
       
        return view('admin.master.inventory.racks.index', compact(['storageRooms', 'blocks']));
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
            'storage_room_id' => 'required',
            'name' => 'required|string',
            'rack_no' => 'required',
            'no_of_levels' => 'required',
            'no_of_depth' => 'required',
            // 'capacity' => 'required|numeric',
            // 'position_x' => 'required',
            // 'position_y' => 'required',
        ]);

        Rack::create([
            'room_id' => $request->storage_room_id,
            'block_id' => $request->block_id,
            'name' => $request->name,
            'rack_no' => $request->rack_no,
            'capacity' => $request->capacity,
            'position_x' => $request->position_x,
            'position_y' => $request->position_y,
            'no_of_levels' => $request->no_of_levels,
            'no_of_depth' => $request->no_of_depth,
        ]);

        // $this->generateSlots($rack->rack_id);

        return redirect()->route('admin.master.inventory.racks.index')->with('success', 'Rack added successfully!');
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
            'storage_room_id' => 'required',
            'name' => 'required|string',
            'rack_no' => 'required',
            'no_of_levels' => 'required|integer',
            'no_of_depth' => 'required|integer',
            // 'capacity' => 'nullable|numeric',
            // 'position_x' => 'nullable',
            // 'position_y' => 'nullable',
        ]);

        $rack = Rack::with('slots.pallet.availableProducts')->findOrFail($id);

        $newLevels = (int) $request->input('no_of_levels');
        $newDepth = (int) $request->input('no_of_depth');
        $oldLevels = $rack->no_of_levels;
        $oldDepth = $rack->no_of_depth;

        // Check if any slot's pallet has products assigned
        $hasProducts = $rack->slots->contains(function ($slot) {
            return $slot->pallet && $slot->pallet->availableProducts->isNotEmpty();
        });

        // Prevent dimension change if products are already assigned
        if ($hasProducts && ($newLevels != $oldLevels || $newDepth != $oldDepth)) {
            return redirect()->back()->withErrors('Cannot update rack dimensions. Products already assigned to pallets.');
        }

        // Update rack
        $rack->fill([
            'room_id' => $request->storage_room_id,
            'block_id' => $request->block_id,
            'name' => $request->name,
            'rack_no' => $request->rack_no,
            'capacity' => $request->capacity,
            'position_x' => $request->position_x,
            'position_y' => $request->position_y,
            'no_of_levels' => $newLevels,
            'no_of_depth' => $newDepth,
        ]);

        $rack->save();

        // Regenerate slots only if dimensions changed and no products exist
        if (!$hasProducts && (
            $newLevels != $rack->no_of_levels || $newDepth != $rack->no_of_depth
        )) {
            try {
                $rack->generateSlots();
            } catch (\Exception $e) {
                \Log::error('Failed to regenerate slots on rack update: ' . $e->getMessage());
                return redirect()->back()->withErrors('Failed to regenerate slots.');
            }
        }

        return redirect()->route('admin.master.inventory.racks.index')->with('success', 'Rack updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rack = Rack::findOrFail($id);
        $rack->delete();

        return redirect()->route('admin.master.inventory.racks.index')->with('success', 'Rack deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $rack = Rack::findOrFail($request->id);
        $rack->is_active = !$rack->is_active;
        $rack->save();

        return response()->json(['success' => true, 'status' => $rack->is_active]);
    }

    // Fetch available racks in a selected storage room
    public function getRacks(Request $request)
    {
        $racks = Rack::with(['slots.pallet.products'])
                ->whereHas('room', function ($query) use ($request) {
                    $query->where('room_id', $request->room_id);
                })
                ->whereHas('slots', function ($query) use ($request) {
                    $query->where('room_id', $request->room_id)
                          ->whereIn('status', ['empty', 'partial']);
                })
                ->get();

        return response()->json(['racks' => $racks]);
    }

    public function getRackDetails(Request $request)
    {
        $rack = Rack::with(['slots.pallet.products','slots.pallet.products.CatSvgIcon'])->find($request->rack_id);
        return response()->json(['rack' => $rack]);
    }

    public function generateSlots($rackId)
    {
        $rack = Rack::with(['slots.pallet.availableProducts', 'room'])->findOrFail($rackId);

        // Prevent generation if any pallet in a slot has products
        foreach ($rack->slots as $slot) {
            if ($slot->pallet && $slot->pallet->availableProducts()->exists()) {
                return response()->json(['message' => 'Cannot regenerate slots. Products already assigned.'], 403);
            }
        }

        // Delete old slots
        Slot::where('rack_id', $rack->id)->delete();

        $levels = $rack->no_of_levels;
        $depth = $rack->no_of_depth;
        $rackNo = strtoupper($rack->rack_no);
        $roomNo = strtoupper($rack->room->name);

        // Find last slot number used (numeric part of slot_no like S10, S11)
        $lastSlot = Slot::where('slot_no', 'LIKE', 'S%')
            ->orderByRaw('CAST(SUBSTRING(slot_no, 2) AS UNSIGNED) DESC')
            ->first();

        $lastNumber = $lastSlot ? (int) substr($lastSlot->slot_no, 1) : 0;
        $counter = $lastNumber + 1;

        // Create slots based on levels and depth
        for ($l = 1; $l <= $levels; $l++) {
            for ($d = 1; $d <= $depth; $d++) {
                $slotNo = 'S' . $counter++;

                Slot::create([
                    'rack_id' => $rack->rack_id,
                    'block_id' => $rack->block_id,
                    'slot_no' => $slotNo,
                    'name' => $slotNo,
                    'level_no' => 'L' . $l,
                    'depth_no' => 'D' . $d,
                ]);
            }
        }

        return response()->json(['message' => 'Slots generated successfully.']);
    }

}

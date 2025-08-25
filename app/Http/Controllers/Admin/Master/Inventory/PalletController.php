<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Block;
use App\Models\Master\Inventory\Pallet;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\PalletType;
use App\Models\Master\General\Unit;

class PalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storageRooms = StorageRoom::with('racks.pallets')->get();
        $blocks = Block::active()->get();
        $units = Unit::active()->get();
        $racks = Rack::active()->get();
        $palletTypes = PalletType::active()->get();

        $data = Pallet::with('rack')
                    ->select('cs_pallets.*');
        
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
                            $w->where('pallet_no', 'LIKE', "%$search%")
                              ->orWhere('name', 'LIKE', "%$search%")
                              ->orWhereHas('rack', function($q) use($search){
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
                ->addColumn('rack_name', function ($row) {
                    return $row->rack ? $row->rack->name : 'No Rack';
                })
                ->addColumn('slot_name', function ($row) {
                    return $row->slot ? $row->slot->name : 'No Rack';
                })
                ->addColumn('pallet_type', function ($row) {
                    return $row->palletType ? $row->palletType->type_name : 'Nil';
                })
                ->editColumn('active', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->pallet_id}'>" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-pallet-btn' 
                        data-id='{$res->pallet_id}'
                        data-no='{$res->pallet_no}'
                        data-name='{$res->name}'
                        data-roomid='{$res->room_id}'
                        data-rackid='{$res->rack_id}'
                        data-slotid='{$res->slot_id}'
                        data-pallet-type-id='{$res->pallet_type_id}'
                        data-capacityunit='{$res->capacity_unit_id}'
                        data-capacity='{$res->capacity}'
                        data-pallet-position='{$res->pallet_position}'
                        data-barcode='{$res->barcode}'
                        data-max_weight='{$res->max_weight}'
                        title='Edit'
                    ><i class='fas fa-edit' ></i></button>";
        
                    $deleteForm = "<form action='" . route('admin.master.inventory.pallets.destroy', $res->pallet_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete' ><i class='fas fa-trash' ></i></button>
                    </form>";
        
                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }
        
        return view('admin.master.inventory.pallets.index', compact('storageRooms', 'racks', 'blocks', 'units', 'palletTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rack_id' => 'required',
            'pallet_no' => 'required',
            'name' => 'required',
            'pallet_position' => 'required',
            // 'barcode' => 'required|string',
            // 'max_weight' => 'required|numeric',
            // 'status' => 'required'
        ]);
        
        Pallet::create([
            'room_id' => $request->storage_room_id,
            'block_id' => $request->block_id,
            'rack_id' => $request->rack_id,
            'slot_id' => $request->slot_id,
            'name' => $request->name,
            'barcode' => $request->barcode,
            'pallet_type_id' => $request->pallet_type_id,
            'capacity_unit_id' => $request->capacity_unit_id,
            'capacity' => $request->capacity,
            'max_weight' => $request->max_weight,
            'pallet_position' => $request->pallet_position,
        ]);
        
        return redirect()->route('admin.master.inventory.pallets.index')->with('success', 'Pallet created successfully.');
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
            'rack_id' => 'required',
            'pallet_no' => 'required',
            'name' => 'required|string',
            'pallet_position' => 'required',
            // 'barcode' => 'required|string',
            // 'max_weight' => 'required|numeric',
            // 'status' => 'required'
        ]);
        
        $pallet = Pallet::findOrFail($id);
        $pallet->fill($request->only([
            'pallet_no',
            'name',
            'room_id',
            'block_id',
            'rack_id',
            'slot_id',
            'barcode',
            'pallet_type_id',
            'capacity_unit_id',
            'capacity',
            'max_weight',
            'pallet_position',
            'status'
        ]));

        $pallet->save();
    
        return redirect()->route('admin.master.inventory.pallets.index')->with('success', 'Pallet updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pallet = Pallet::findOrFail($id);
        $pallet->delete();

        return redirect()->route('admin.master.inventory.pallets.index')->with('success', 'Pallet deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $pallet = Pallet::findOrFail($request->id);
        $pallet->is_active = !$pallet->is_active;
        $pallet->save();

        return response()->json(['success' => true, 'status' => $pallet->is_active]);
    }

    // Fetch available pallets in a selected rack
    public function getPallets(Request $request)
    {
        $pallets = Pallet::where('rack_id', $request->rack_id)->get();

        return response()->json(['pallets' => $pallets]);
    }

}

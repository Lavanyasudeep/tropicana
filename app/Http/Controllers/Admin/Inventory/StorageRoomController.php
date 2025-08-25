<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;

use App\Models\Inventory\Stock;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Pallet;

class StorageRoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();

        $data = Stock::with(['rack.room', 'slot', 'pallet.products', 'product', 'grnDetail.grn', 'packingListDetail.packingList'])->select('cs_stock.*');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->get('date') != '') {
                        $instance->whereDate('created_at', $request->get('date'));
                    }
                    if ($request->get('product') != '') {
                        $instance->whereHas('product', function($q) use ($request) {
                            $q->where('product_description', 'like', '%' . $request->product . '%');
                        });
                    }
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                  
                        $instance->where(function ($w) use ($search) {
                            $w->whereHas('rack.room', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            })->orWhereHas('rack', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('pallet', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('product', function ($q) use ($search) {
                                $q->where('product_description', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('grnDetail.grn', function ($q) use ($search) {
                                $q->where(DB::raw('CONCAT(Prefix, Suffix)'), 'LIKE', "%$search%");
                            });
                        });
                    }
                })
                ->addColumn('packing_list_id', function ($row) {
                    return $row->packingListDetail ? $row->PackingListDetail->PackingList->packing_list_id : '';
                })
                ->addColumn('client_name', function ($row) {
                    return $row->packingListDetail ? $row->PackingListDetail->PackingList->client->client_name : '';
                })
                ->addColumn('storage_room_name', function ($row) {
                    return $row->rack->room ? $row->rack->room->name : 'No Room';
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.inventory.storage-room.index', compact('rooms'));
    }

    public function getRacks($roomId)
    {
        $room = StorageRoom::with(['racks.slots.pallet', 'racks.slots.room', 'racks.slots.rack'])->findOrFail($roomId);
        $racks = $room->racks;
        return view('admin.inventory.storage-room.partials.rack-list', compact('room', 'racks'));
    }

    public function getRackDetail($roomId, $rackId)
    {
        $rack = Rack::with(['slots.pallet'])->findOrFail($rackId);
        return view('admin.inventory.storage-room.partials.rack-details', compact('rack'));
    }

    public function getPalletDetail($palletId)
    {
        $pallet = Pallet::findOrFail($palletId);
        return view('admin.inventory.storage-room.partials.pallet-details', compact('pallet'));
    }
}

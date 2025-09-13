<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Inventory\PackingList;
use App\Models\Inventory\PackingListDetail;
use App\Models\Inventory\Inward;
use App\Models\Inventory\InwardDetail;
use App\Models\Master\Purchase\Supplier;
use App\Models\Client;
use App\Models\Master\General\Unit;
use App\Models\Master\Inventory\ProductCategory;
use App\Models\Master\General\Brand;
use App\Models\Master\Inventory\Slot;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Pallet;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\ProductMaster;
use App\Models\Master\General\Status;

use App\Services\Inventory\InventoryStatusTransitionService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use DataTables;
use Carbon\Carbon;

class SlottingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();
        $racks = Rack::with(['slots.pallet'])->get();

        return view('admin.inventory.slotting.index', compact('clients', 'rooms', 'racks')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id=null)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }

    public function print($id)
    {
        
    }

    public function changeStatus(Request $request, InventoryStatusTransitionService $service)
    {
        
    }

}

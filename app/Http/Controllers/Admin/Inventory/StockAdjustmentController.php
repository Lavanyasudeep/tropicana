<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Inventory\StockAdjustment;
use App\Models\Inventory\StockAdjustmentDetail;
use App\Models\Inventory\Stock;
use App\Models\Master\Inventory\ProductMaster;
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
use App\Models\Master\Inventory\PalletType;

use App\Enums\StockAdjustmentReason;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use DataTables;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $clients = Client::all();
         session()->forget('adjustment_products');
        
        if ($request->ajax()) {
            $query = StockAdjustment::with(['stockAdjustmentDetails.product', 'stockAdjustmentDetails.room', 'stockAdjustmentDetails.rack', 'stockAdjustmentDetails.slot', 'stockAdjustmentDetails.pallet', 'client']);
            
            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if ($search != '') {
                        $query->where(function ($q) use ($search) {
                            $q->where('doc_no', 'like', "%{$search}%")
                                ->orWhereHas('client', function ($q2) use ($search) {
                                    $q2->where('client_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('stockAdjustmentDetails.room', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('stockAdjustmentDetails.rack', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('stockAdjustmentDetails.slot', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('stockAdjustmentDetails.pallet', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('stockAdjustmentDetails.product', function ($q2) use ($search) {
                                    $q2->where('product_description', 'like', "%{$search}%");
                                })
                                ->orWhereHas('batch_no', function ($q2) use ($search) {
                                    $q2->where('batch_no', 'like', "%{$search}%");
                                });
                        });
                    }
                    
                    if ($request->from_date && $request->to_date) {
                        $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                        $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

                        $query->whereBetween('created_at', [
                                    $from_date,
                                    $to_date
                                ]);
                    }

                    if ($request->filled('client_flt')) {
                        $query->where('client_id', $request->client_flt);
                    }
                })
                ->editColumn('doc_date', function ($stockAdj) {
                    return $stockAdj->formatDate('doc_date');
                })
                ->addColumn('no_of_items', function ($stockAdj) {
                    return $stockAdj->stockAdjustmentDetails->count();
                })
                ->addColumn('status', function ($stockAdj) {
                    return ucfirst($stockAdj->status);
                })
                ->addColumn('action', function ($stockAdj) {
                    // $act = '<a href="'.route('admin.inventory.stock-adjustment.edit', $stockAdj->stock_adjustment_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act = '<a href="' . route('admin.inventory.stock-adjustment.print', $stockAdj->stock_adjustment_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.inventory.stock-adjustment.view', $stockAdj->stock_adjustment_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    return $act;
                })
                ->rawColumns(['doc_no',  'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.inventory.stock-adjustment.index', compact('clients')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::select('client_id', 'client_name')->get();
        $products = ProductMaster::select('product_master_id', 'product_description')->orderBy('product_description')->limit(100)->get();
    
        $adjustmentProducts = session('adjustment_products')??[];

        $packingListDetail = PackingListDetail::with(['product', 'grnDetail.grn', 'packingList.client', 'packageType', 'pallets'])
                ->select('cs_packing_list_detail.*')
                ->get()
                ->keyBy('packing_list_detail_id');

        $stockAdjustmentReasons = collect(StockAdjustmentReason::cases())->map(function ($case) {
                            return [
                                'value' => $case->value,
                                'label' => $case->label(),
                            ];
                        })->values();

        // Handle AJAX request for DataTable
        if ($request->ajax()) {
            // If client_id is not passed, return empty
            
            if (!$request->filled('client_flt')) {
                return datatables()->of(collect())->make(true);
            }

            $clientId = $request->input('client_flt');
           
            $query = Stock::with('product')
                        ->whereHas('packingListDetail.packingList.client', fn($q) => $q->where('client_id', $clientId))
                        ->where('available_qty', '>', 0)
                        ->selectRaw('product_id, batch_no, expiry_date, packing_list_detail_id, SUM(available_qty) as tot_avl_qty')
                        ->groupBy(['packing_list_detail_id', 'product_id', 'batch_no', 'expiry_date']);

            // Return filtered data
            return DataTables::eloquent($query)
                ->addColumn('product_name', fn($row) => $row->product->product_description ?? '-')
                ->addColumn('tot_avl_qty', fn($row) => $row->tot_avl_qty ?? '-')
                ->addColumn('grn_no', function ($row) {
                    $grn = $row?->packingListDetail?->packingList?->grn;

                    return ($grn?->Prefix. $grn?->Suffix) ?? '';
                })
                ->addColumn('grn_qty', function ($row) {
                    return $row?->packingListDetail?->grnDetail?->ReceivedQuantity ?? 0;
                })
                ->make(true);
        }
        
        return view('admin.inventory.stock-adjustment.create', compact('clients', 'stockAdjustmentReasons', 'adjustmentProducts', 'products', 'packingListDetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $adjustmentProducts = session('adjustment_products');

        if (!$adjustmentProducts || empty($adjustmentProducts)) {
            return back()->withErrors(['error' => 'No assigned products found in session'])->withInput();
        }

        $detailIds = collect($adjustmentProducts)->pluck('packing_list_detail_id');
        $packingListIds = PackingListDetail::whereIn('packing_list_detail_id', $detailIds)
            ->pluck('packing_list_id')
            ->unique();

        DB::beginTransaction();

        try {
            foreach ($packingListIds as $packingListId) {
                $palletQty = 0;
                $totPackageQty = 0;

                // Create Stock Adjustment for this Packing List
                $stockAdjustment = StockAdjustment::create(
                    [
                        'doc_date' => $request->doc_date,
                        'client_id' => $request->client_id ?? null,
                        'reason'    => $request->reason??null,
                        'remarks'  => $request->remarks??null,
                        'tot_pallet_qty' => 0,
                        'total_package_qty' => 0,
                    ]
                );

                foreach ($adjustmentProducts as $product) {
                    if ($product['packing_list_id'] != $packingListId) continue;

                    $packingListDetailId = $product['packing_list_detail_id'];
                    $packingListDetail = PackingListDetail::with(['product', 'grnDetail', 'packingList'])->findOrFail($packingListDetailId);

                    // Prevent duplicate assignment
                    // if ($packingListDetail?->grnDetail?->is_fully_assigned_to_cold_storage) {
                    //     throw new \Exception("Packing List Detail ID {$packingListDetailId} is already assigned to cold storage.");
                    // }

                    // // Update Product Master Box Capacity
                    // ProductMaster::where('product_id', $product['product_id'])
                    //     ->update([
                    //         'box_capacity_per_full_pallet' => $product['package_qty_per_full_pallet'],
                    //         'box_capacity_per_half_pallet' => $product['package_qty_per_half_pallet']
                    //         ]);

                    // // Update Packing List Detail info
                    // $packingListDetail->fill([
                    //     'package_qty_per_full_pallet' => $product['package_qty_per_full_pallet'],
                    //     'package_qty_per_half_pallet' => $product['package_qty_per_half_pallet'],
                    //     'pallet_qty' => $product['pallet_qty']
                    // ]);

                    // $packingListDetail->save();

                    $selectedSlots = json_decode($product['selected_slots'], true);

                    foreach ($selectedSlots as $selectedSlot) {
                        $slot = Slot::findOrFail($selectedSlot['slot_id']);

                        if (!$slot->has_pallet) {
                            $pallet = Pallet::create([
                                'room_id' => $selectedSlot['room_id'],
                                'rack_id' => $selectedSlot['rack_id'],
                                'block_id' => $slot->block_id,
                                'slot_id' => $selectedSlot['slot_id'],
                                'capacity_unit_id' => $packingListDetail->product->ProductPackingID,
                                'pallet_type_id' => $selectedSlot['pallet_type_id'],
                                'capacity' => $selectedSlot['capacity'],
                                'weight' => $packingListDetail->packingList->weight_per_pallet,
                                'client_id' => $product['client_id'] ?? $request->client_id,
                                'is_active' => 1
                            ]);
                            $pallet_id = $pallet->pallet_id;
                        } else {
                            $pallet_id = $slot->pallet->pallet_id;
                        }

                        // Create stock adjustment detail
                        $stockAdjDetail =  StockAdjustmentDetail::create([
                            'stock_adjustment_id' => $stockAdjustment->stock_adjustment_id,
                            'product_id' => $packingListDetail->product_id,
                            'product_description' => $packingListDetail->cargo_description,
                            'batch_no' => $packingListDetail->lot_no,
                            'expiry_date' => $packingListDetail->expiry_date,
                            'packing_list_id' => $packingListDetail->packing_list_id,
                            'packing_list_detail_id' => $packingListDetailId,
                            'room_id' => $selectedSlot['room_id'],
                            'rack_id' => $selectedSlot['rack_id'],
                            'slot_id' => $selectedSlot['slot_id'],
                            'pallet_id' => $pallet_id,
                            'quantity' => $selectedSlot['quantity'],
                            'weight_per_unit' => $packingListDetail->grnDetail?->WeightPerUnit,
                            'unit_id' => $packingListDetail->product?->purchase_unit_id,
                            'package_qty_per_full_pallet' => $product['package_qty_per_full_pallet'],
                            'package_qty_per_half_pallet' => $product['package_qty_per_half_pallet'],
                            'movement_type' => $product['movement_type'],
                            'reason' => $product['reason']
                        ]);

                        $palletQty++;
                        $totPackageQty += $selectedSlot['quantity'];
                    }
                }

                // Update pallet summary on inward
                $stockAdjustment->fill([
                    'tot_pallet_qty' => $palletQty,
                    'total_package_qty' => $totPackageQty
                ]);

                $stockAdjustment->save();
            }

            DB::commit();
            session()->forget('adjustment_products');

            return redirect()->route('admin.inventory.stock-adjustment.index')->with('success', 'Items adjusted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to submit product to inward',
                'details' => $e->getMessage()
            ])->withInput();
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Assign the specified resource from storage.
     */
    public function assign(Request $request, string $packingListID, string $id)
    {
        // dd($request->all());
        $adjustmentProducts = session('adjustment_products')??null;
        $productId = $request->input('product_id');
        $packageQty = $request->input('package_qty');
        $movementType = $request->input('movement_type');
        $packageQtyPerFullPallet = $request->input('package_qty_per_full_pallet');
        $packageQtyPerHalfPallet = $request->input('package_qty_per_half_pallet');
        $reason = $request->input('reason');
        $adjustmentProduct = array_filter(json_decode($request->input('adjustment_products'), true) ?? [],
                fn ($item) => !empty($item) && is_array($item)
            );

        if(isset($adjustmentProduct[$id])) {
            $adjustmentProducts[$id] = $adjustmentProduct[$id];
        }
        
        $adjustmentProducts[$id]['package_qty'] = $packageQty;
        $adjustmentProducts[$id]['movement_type'] = $movementType;
        $adjustmentProducts[$id]['reason'] = $reason;
        $adjustmentProducts[$id]['package_qty_per_full_pallet'] = $packageQtyPerFullPallet;
        $adjustmentProducts[$id]['package_qty_per_half_pallet'] = $packageQtyPerHalfPallet;
        session()->put('adjustment_products', $adjustmentProducts);
        
        $availableSlots = Slot::with(['stocks','room','rack', 'pallet.palletType']) 
            ->whereIn('status', ['partial', 'empty', 'full'])
            ->get()
            ->map(function ($slot) {
                return [
                    'status' => $slot->status,
                    'slot_id' => $slot->slot_id,
                    'room_name' => $slot->room->name,
                    'rack_no' =>$slot->rack->rack_no,
                    'level_no' => $slot->level_no,
                    'depth_no' => $slot->depth_no,
                    'total' => $slot->pallet->pallet_capacity ?? 0,
                    'current' => $slot->pallet->current_pallet_capacity ?? 0
                ];
            });
                         
        $packingList = PackingList::with('packingListDetails')->findOrFail($packingListID);
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();
        $racks = Rack::with(['slots.pallet'])->get();
        $racks_array = Rack::with(['slots.pallet.palletType', 'slots.stocks'])->get()->toArray();
        $packingListDetail = PackingListDetail::with(['stocks','product','inward'])->findOrFail($id);
        $clients = Client::all();
        $defaultDate = Carbon::now()->format('Y-m-d');
        $palletTypes = PalletType::active()->get();

        return view('admin.inventory.stock-adjustment.in', compact('packingList', 'rooms', 'racks', 'racks_array', 'packingListID', 'packingListDetail', 'availableSlots', 'clients', 'defaultDate', 'productId', 'packageQty', 'packageQtyPerFullPallet', 'packageQtyPerHalfPallet', 'adjustmentProducts', 'palletTypes', 'movementType', 'reason'));
    }

    public function saveAssignedSlots(Request $request)
    {
        $data = $request->only([
            'packing_list_id',
            'packing_list_detail_id',
            'product_id',
            'movement_type',
            'reason',
            'package_qty',
            'package_qty_per_full_pallet',
            'package_qty_per_half_pallet',
            'selected_slots'
        ]);
        
        if(session()->get('adjustment_products'))
            $adjustment_products = session()->get('adjustment_products');
        else
            $adjustment_products = [];
        
        if(isset($adjustment_products[$data['packing_list_detail_id']]['packing_list_id'])) {
            if($adjustment_products[$data['packing_list_detail_id']]['packing_list_id'] != $data['packing_list_id']) {
                session()->forget('adjustment_products');
                $adjustment_products = [];
            }
        }

        if(!isset($adjustment_products[$data['packing_list_detail_id']]))
            $adjustment_products[$data['packing_list_detail_id']] = [];
        
        //$adjustment_products[$data['packing_list_detail_id']] = $data;
        $adjustment_products[$data['packing_list_detail_id']]['selected_slots'] = $data['selected_slots'];
        $adjustment_products[$data['packing_list_detail_id']]['package_qty'] = $data['package_qty'];
        $adjustment_products[$data['packing_list_detail_id']]['package_qty_per_full_pallet'] = $data['package_qty_per_full_pallet'];
        $adjustment_products[$data['packing_list_detail_id']]['package_qty_per_half_pallet'] = $data['package_qty_per_half_pallet'];

        session()->put('adjustment_products', $adjustment_products);

        return redirect()->route('admin.inventory.stock-adjustment.create');
    }

    /**
     * Re-Assign the specified resource from storage.
     */
     public function reassign(Request $request, string $packingListID, string $id)
    {
        $adjustmentProducts = session('adjustment_products')??null;
        $productId = $request->input('product_id');
        $packageQty = $request->input('package_qty');
        $movementType = $request->input('movement_type');
        $packageQtyPerFullPallet = $request->input('package_qty_per_full_pallet');
        $packageQtyPerHalfPallet = $request->input('package_qty_per_half_pallet');
        $reason = $request->input('reason');
        $adjustmentProduct = array_filter(json_decode($request->input('adjustment_products'), true) ?? [],
                fn ($item) => !empty($item) && is_array($item)
            );

        if(isset($adjustmentProduct[$id])) {
            $adjustmentProducts[$id] = $adjustmentProduct[$id];
        }
        
        $adjustmentProducts[$id]['package_qty'] = $packageQty;
        $adjustmentProducts[$id]['movement_type'] = $movementType;
        $adjustmentProducts[$id]['reason'] = $reason;
        $adjustmentProducts[$id]['package_qty_per_full_pallet'] = $packageQtyPerFullPallet;
        $adjustmentProducts[$id]['package_qty_per_half_pallet'] = $packageQtyPerHalfPallet;
        session()->put('adjustment_products', $adjustmentProducts);

        $availableSlots = Slot::with(['stocks','room','rack', 'pallet.palletType']) 
            ->whereIn('status', ['partial', 'empty', 'full'])
            ->get()
            ->map(function ($slot) {
                return [
                    'status' => $slot->status,
                    'slot_id' => $slot->slot_id,
                    'room_name' => $slot->room->name,
                    'rack_no' =>$slot->rack->rack_no,
                    'level_no' => $slot->level_no,
                    'depth_no' => $slot->depth_no,
                    'total' => $slot->pallet->pallet_capacity ?? 0,
                    'current' => $slot->pallet->current_pallet_capacity ?? 0
                ];
            });
                         
        $packingList = PackingList::with('packingListDetails')->findOrFail($packingListID);
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();
        $racks = Rack::with(['slots.pallet'])->get();
        $racks_array = Rack::with(['slots.pallet.palletType', 'slots.stocks'])->get()->toArray();
        $packingListDetail = PackingListDetail::with(['stocks','product','inward'])->findOrFail($id);
        $clients = Client::all();
        $defaultDate = Carbon::now()->format('Y-m-d');
        $palletTypes = PalletType::active()->get();

        return view('admin.inventory.stock-adjustment.out', compact('packingList', 'rooms', 'racks', 'racks_array', 'packingListID', 'packingListDetail', 'availableSlots', 'clients', 'defaultDate', 'productId', 'packageQty', 'packageQtyPerFullPallet', 'packageQtyPerHalfPallet', 'adjustmentProducts', 'palletTypes'));
    }

    public function saveReAssignedSlots(Request $request)
    {
        $data = $request->only([
            'packing_list_id',
            'packing_list_detail_id',
            'product_id',
            'movement_type',
            'reason',
            'package_qty',
            'package_qty_per_full_pallet',
            'package_qty_per_half_pallet',
            'selected_slots'
        ]);
        
        if(session()->get('adjustment_products'))
            $adjustment_products = session()->get('adjustment_products');
        else
            $adjustment_products = [];
        
        if(isset($adjustment_products[$data['packing_list_detail_id']]['packing_list_id'])) {
            if($adjustment_products[$data['packing_list_detail_id']]['packing_list_id'] != $data['packing_list_id']) {
                session()->forget('adjustment_products');
                $adjustment_products = [];
            }
        }

        if(!isset($adjustment_products[$data['packing_list_detail_id']]))
            $adjustment_products[$data['packing_list_detail_id']] = [];
        
        //$adjustment_products[$data['packing_list_detail_id']] = $data;
        $adjustment_products[$data['packing_list_detail_id']]['selected_slots'] = $data['selected_slots'];
        $adjustment_products[$data['packing_list_detail_id']]['package_qty'] = $data['package_qty'];
        $adjustment_products[$data['packing_list_detail_id']]['package_qty_per_full_pallet'] = $data['package_qty_per_full_pallet'];
        $adjustment_products[$data['packing_list_detail_id']]['package_qty_per_half_pallet'] = $data['package_qty_per_half_pallet'];

        session()->put('adjustment_products', $adjustment_products);

        return redirect()->route('admin.inventory.stock-adjustment.create');
    }

    public function removeAdjustmentProduct(Request $request)
    {
        $packing_list_detail_id = $request->packing_list_detail_id;

        if(session()->get('adjustment_products')) {
            $adjustment_products = session()->get('adjustment_products');
            if(isset($adjustment_products[$packing_list_detail_id])) {
                unset($adjustment_products[$packing_list_detail_id]);
                session()->put('adjustment_products', $adjustment_products);
            }
        }

        echo 1;
    }
}

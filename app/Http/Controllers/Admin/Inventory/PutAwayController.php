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

class PutAwayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();
        $racks = Rack::with(['slots.pallet'])->get();

        return view('admin.inventory.put-away.index', compact('clients', 'rooms', 'racks')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id=null)
    {
        $packingList = null;
        $packedIds = [];
        $assignedProduct = null;

        if (!$id) {
            session()->forget('assigned_product');
        }

        if ($id) {
            $packingList = PackingList::with('packingListDetails')->findOrFail($id);
            $packedIds = $packingList->packingListDetails->pluck('packing_list_detail_id')->toArray();
            $assignedProduct = session('assigned_product')??null;
        }

        $suppliers = Supplier::select('supplier_id', 'supplier_name')->get();
        $clients = Client::select('client_id', 'client_name')->get();
        $categories = ProductCategory::select('product_category_id', 'product_category_name')->orderBy('product_category_name')->limit(100)->get();
        $brands = Brand::select('brand_id', 'brand_name')->get();
        $packageTypes = Unit::select('unit_id', 'description')->get();
        $packingLists = PackingList::select('packing_list_id', 'doc_no')->get();
       
        // Handle AJAX request for DataTable
        if ($request->ajax()) {
            
            if (!$request->filled('packing_list_id')) {
                return datatables()->of(collect())->make(true);
            }
            
            $query = PackingListDetail::with(['product', 'grnDetail.grn', 'packingList.client', 'packageType', 'pallets'])
                ->where('packing_list_id', $request->packing_list_id)
                ->whereHas('packingList', fn($q) => $q->where('status', 'created'))
                ->select('cs_packing_list_detail.*');

            $cols = $request->get('columns');

            if (!empty($cols[5]['search']['value'])) {
                $query->whereHas('product', fn($q) =>
                    $q->where('product_description', 'like', '%' . $cols[5]['search']['value'] . '%')
                );
            }

            if (!empty($cols[6]['search']['value'])) {
                $query->where('batch_no', 'like', '%' . $cols[6]['search']['value'] . '%');
            }

            return DataTables::eloquent($query)
                ->addColumn('product_name', fn($row) => $row->product->product_description ?? '-')
                ->addColumn('batch_no', fn($row) => $row->lot_no ?? '-')
                ->addColumn('size', fn($row) => $row->item_size_per_package ?? '')
                ->addColumn('weight_per_unit', fn($row) => $row->grnDetail->WeightPerUnit ?? '')
                ->addColumn('package_type', fn($row) => $row->packageType?->description ?? '')
                ->addColumn('gw_per_package', fn($row) => $row->gw_per_package ?? '')
                ->addColumn('nw_per_package', fn($row) => $row->nw_per_package ?? '')
                ->addColumn('gw_with_pallet', fn($row) => $row->gw_with_pallet ?? '')
                ->addColumn('nw_kg', fn($row) => $row->nw_kg ?? '')
                ->addColumn('pallet_positions', function ($row) {
                    return $row->pallets->pluck('pallet_position')->implode(', ');
                })
                ->addColumn('is_fully_assigned_to_cold_storage', function ($row) {
                    return $row->grnDetail->is_fully_assigned_to_cold_storage;
                })
                ->make(true);
        }

        return view('admin.inventory.inward.create', compact('packingLists', 'packingList', 'suppliers', 'clients', 'packageTypes', 'categories', 'brands', 'assignedProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $assignedProduct = session('assigned_product');

        if (!$assignedProduct || empty($assignedProduct)) {
            return back()->withErrors(['error' => 'No assigned products found in session'])->withInput();
        }

        $detailIds = collect($assignedProduct)->pluck('packing_list_detail_id');
        $packingListIds = PackingListDetail::whereIn('packing_list_detail_id', $detailIds)
            ->pluck('packing_list_id')
            ->unique();

        DB::beginTransaction();

        try {
            foreach ($packingListIds as $packingListId) {
                $palletQty = 0;
                $totPackageQty = 0;

                // Create or fetch Inward for this Packing List
                $inward = Inward::firstOrCreate(
                    ['packing_list_id' => $packingListId],
                    [
                        'doc_date' => $request->doc_date,
                        'client_id' => $request->client_id ?? null,
                        'pallet_qty' => 0
                    ]
                );

                foreach ($assignedProduct as $product) {
                    if ($product['packing_list_id'] != $packingListId) continue;

                    $packingListDetailId = $product['packing_list_detail_id'];
                    $packingListDetail = PackingListDetail::with(['product', 'grnDetail', 'packingList'])->findOrFail($packingListDetailId);

                    // Prevent duplicate assignment
                    if ($packingListDetail?->grnDetail?->is_fully_assigned_to_cold_storage) {
                        throw new \Exception("Packing List Detail ID {$packingListDetailId} is already assigned to cold storage.");
                    }

                    // Update Product Master Box Capacity
                    ProductMaster::where('product_id', $product['product_id'])
                        ->update(['box_capacity_per_full_pallet' => $product['package_qty_per_pallet']]);

                    // Update Packing List Detail info
                    $packingListDetail->fill([
                        'package_qty_per_pallet' => $product['package_qty_per_pallet'],
                        'pallet_qty' => $product['pallet_qty']
                    ]);
                    $packingListDetail->save();

                    $selectedSlots = json_decode($product['selected_slots'], true);

                    foreach ($selectedSlots as $selectedSlot) {
                        $slot = Slot::findOrFail($selectedSlot['slot_id']);

                        if ($slot->has_pallet) {
                            throw new \Exception("Slot ID {$slot->slot_id} already has a pallet.");
                        }

                        // Create new pallet
                        $pallet = Pallet::create([
                            'room_id' => $selectedSlot['room_id'],
                            'rack_id' => $selectedSlot['rack_id'],
                            'slot_id' => $selectedSlot['slot_id'],
                            'capacity_unit_id' => $packingListDetail->product->ProductPackingID,
                            'capacity' => $product['package_qty_per_pallet'],
                            'weight' => $packingListDetail->packingList->weight_per_pallet,
                            'client_id' => $product['client_id'] ?? $request->client_id,
                            'is_active' => 1
                        ]);

                        // Create inward detail
                        InwardDetail::create([
                            'inward_id' => $inward->inward_id,
                            'packing_list_detail_id' => $packingListDetailId,
                            'room_id' => $selectedSlot['room_id'],
                            'rack_id' => $selectedSlot['rack_id'],
                            'slot_id' => $selectedSlot['slot_id'],
                            'pallet_id' => $pallet->pallet_id,
                            'quantity' => $selectedSlot['quantity']
                        ]);

                        $palletQty++;
                        $totPackageQty += $selectedSlot['quantity'];
                    }
                }

                // Update pallet summary on inward
                $inward->fill([
                    'pallet_qty' => $palletQty,
                    'tot_package_qty' => $totPackageQty
                ]);
                $inward->save();
            }

            DB::commit();
            session()->forget('assigned_product');

            return redirect()->route('admin.inventory.inward.index')->with('success', 'Items submitted to inward successfully.');
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
        $inward = Inward::with([
            'inwardDetails.statusUpdates.creator', 
            'inwardDetails.packingListDetail.grnDetail.productVariant.productSpecifications.specification.attribute',
            'inwardDetails.statusUpdates.target.pallet'])->findOrFail($id);
        $inwardDetails = InwardDetail::with('packingListDetail.packageType', 'packingListDetail.packingList')
                                ->where('inward_id', $id)
                                ->get()
                                ->groupBy(function ($item) {
                                        return $item->packingListDetail->product_id . '_' . $item->packingListDetail->lot_no . '_' . $item->packingListDetail->expiry_date;
                                    })
                                ->map(function ($group) {
                                    return [
                                        'product_name' => $group->first()->packingListDetail->product->product_description,
                                        'batch_no' => $group->first()->packingListDetail->lot_no,
                                        'slot_positions' => $group->pluck('pallet.pallet_position')->unique()->implode(', '),
                                        'pallets' => $group->pluck('pallet.name')->unique()->implode(', '),
                                        'item_size_per_package' => $group->map(function ($item) {
                                                    return optional($item->packingListDetail)->item_size_per_package;
                                                })->filter()->unique()->implode(', '),
                                        'weight_per_unit' => $group->first()->packingListDetail->grnDetail->WeightPerUnit,
                                        'package_types' => $group->map(function ($item) {
                                                    return optional(optional($item->packingListDetail)->packageType)->description;
                                                })->filter()->unique()->implode(', '),
                                        'gw_per_package' => $group->first()->packingListDetail->gw_per_package,
                                        'nw_per_package' => $group->first()->packingListDetail->nw_per_package,
                                        'gw_with_pallet' => $group->first()->packingListDetail->gw_with_pallet,
                                        'nw_kg' => $group->first()->packingListDetail->nw_kg,
                                        'total_quantity' => $group->sum('quantity'),
                                        'package_qty_per_pallet' => $group->first()->packingListDetail->package_qty_per_pallet,
                                        'pallet_qty' => $group->pluck('pallet_id')->unique()->count()
                                    ];
                                });

        $transitions = config('status_transitions.inward');
        $service = new InventoryStatusTransitionService($transitions);
        
        $statuses = $inward->inwardDetails->pluck('status')->filter()->unique();

        $nextOptions = collect();

        foreach ($statuses as $status) {
            $nextOptions = $nextOptions->merge(
                $service->getNextAllowed('inward', $status)
            );
        }

        $nextOptions = $nextOptions->unique()->values();

        return view('admin.inventory.inward.view', compact('inward', 'inwardDetails', 'nextOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        // $assignedProduct = session('assigned_product')??null;
        $inward = Inward::with('client', 'packingList.packingListDetails')->findOrFail($id);
        $packingList = $inward->packingList;
        $packedIds = $packingList?->packingListDetails?->pluck('packing_list_detail_id')->toArray() ?? [];
        
        $assignedProduct = (session('assigned_product')!=[])? session('assigned_product'): InwardDetail::with([
                                'packingListDetail.product',
                                'packingListDetail.packageType',
                                'packingListDetail.grnDetail',
                                'slot.rack.room' // Ensure these relationships exist
                            ])
                            ->where('inward_id', $id)
                            ->get()
                            ->groupBy('packing_list_detail_id')
                            ->map(function ($group) use ($id){
                                $first = $group->first();
                                return [
                                    'inward_id' => $id,
                                    'packing_list_id' => $first->packing_list_id,
                                    'packing_list_detail_id' => $first->packing_list_detail_id,
                                    'product_id' => optional($first->packingListDetail)->product_id,
                                    'package_qty' => $group->sum('quantity'),
                                    'package_qty_per_pallet' => optional($first->packingListDetail)->package_qty_per_pallet,
                                    'pallet_qty' => optional($first->packingListDetail)->pallet_qty,
                                    // 'selected_slots' => $group->keyBy('slot_id')->map(function ($item) {
                                    'selected_slots' => collect($group)->keyBy('slot_id')->map(function ($item) {
                                        return [
                                            'inward_detail_id' => $item->inward_detail_id,
                                            'slot_id' => $item->slot_id,
                                            'room_id' => optional($item)->room_id,
                                            'rack_id' => optional($item)->rack_id,
                                            'pallet_id' => optional($item)->pallet_id,
                                            'location' => optional($item->pallet)->pallet_position,
                                            'quantity' => $item->quantity,
                                            'has_pallet' => true,
                                            'is_assigned_deleted' => false,
                                        ];
                                    })->toArray()
                                ];
                            })->toArray();

        $suppliers = Supplier::select('supplier_id', 'supplier_name')->get();
        $clients = Client::select('client_id', 'client_name')->get();
        $categories = ProductCategory::select('product_category_id', 'product_category_name')->orderBy('product_category_name')->limit(100)->get();
        $brands = Brand::select('brand_id', 'brand_name')->get();
        $packageTypes = Unit::select('unit_id', 'description')->get();
        $packingLists = PackingList::select('packing_list_id', 'doc_no')->get();

        // Handle AJAX for DataTable (same as create)
        if ($request->ajax()) {
            if (!$request->filled('packing_list_id')) {
                return datatables()->of(collect())->make(true);
            }

            $query = InwardDetail::with(['packingListDetail.product', 'packingListDetail.grnDetail.grn', 'packingListDetail.packingList.client', 'packingListDetail.packageType'])
                ->where('inward_id', $request->id)
                ->whereHas('inward', fn($q) => $q->where('status', 'created'))
                ->get()
                ->groupBy(function ($item) {
                        return $item->packingListDetail->product_id . '_' . $item->packingListDetail->lot_no . '_' . $item->packingListDetail->expiry_date;
                    })
                ->map(function ($group) {
                    return [
                        'inward_id' => $group->first()->inward_id,
                        'inward_detail_id' => $group->first()->inward_detail_id,
                        'product_id' => $group->first()->packingListDetail->product_id,
                        'packing_list_detail_id' => $group->first()->packing_list_detail_id,
                        'product_name' => $group->first()->packingListDetail->product->product_description,
                        'batch_no' => $group->first()->packingListDetail->lot_no,
                        'slot_positions' => $group->pluck('pallet.pallet_position')->unique()->implode(', '),
                        'pallets' => $group->pluck('pallet.name')->unique()->implode(', '),
                        'item_size_per_package' => $group->map(function ($item) {
                                    return optional($item->packingListDetail)->item_size_per_package;
                                })->filter()->unique()->implode(', '),
                        'weight_per_unit' => $group->first()->packingListDetail->grnDetail->WeightPerUnit??'',
                        'package_types' => $group->map(function ($item) {
                                    return optional(optional($item->packingListDetail)->packageType)->description;
                                })->filter()->unique()->implode(', '),
                        'gw_per_package' => $group->first()->packingListDetail->gw_per_package,
                        'nw_per_package' => $group->first()->packingListDetail->nw_per_package,
                        'gw_with_pallet' => $group->first()->packingListDetail->gw_with_pallet,
                        'nw_kg' => $group->first()->packingListDetail->nw_kg,
                        'package_qty' => $group->first()->packingListDetail->package_qty,
                        'package_qty_per_pallet' => $group->first()->packingListDetail->sum('package_qty_per_pallet'),
                        'pallet_qty' => $group->pluck('pallet_id')->unique()->count()
                    ];
                });

            return DataTables::of($query)
                ->addColumn('inward_id', fn($row) => $row['inward_id'])
                ->addColumn('inward_detail_id', fn($row) => $row['inward_detail_id'] ?? '')
                ->addColumn('product_id', fn($row) => $row['product_id'] ?? '')
                ->addColumn('packing_list_detail_id', fn($row) => $row['packing_list_detail_id'] ?? '')
                ->addColumn('product_name', fn($row) => $row['product_name'] ?? '-')
                ->addColumn('batch_no', fn($row) => $row['batch_no'] ?? '-')
                ->addColumn('size', fn($row) => $row['item_size_per_package'] ?? '')
                ->addColumn('weight_per_unit', fn($row) => $row['weight_per_unit'] ?? '')
                ->addColumn('package_type', fn($row) => $row['package_types'] ?? '')
                ->addColumn('gw_per_package', fn($row) => $row['gw_per_package'] ?? '')
                ->addColumn('nw_per_package', fn($row) => $row['nw_per_package'] ?? '')
                ->addColumn('gw_with_pallet', fn($row) => $row['gw_with_pallet'] ?? '')
                ->addColumn('nw_kg', fn($row) => $row['nw_kg'] ?? '')
                ->addColumn('package_qty', fn($row) => $row['package_qty'] ?? '')
                ->addColumn('package_qty_per_pallet', fn($row) => $row['package_qty_per_pallet'] ?? '')
                ->addColumn('pallet_qty', fn($row) => $row['pallet_qty'] ?? '')
                ->make(true);
        }

        return view('admin.inventory.inward.edit', compact(
            'inward',
            'packingList',
            'packedIds',
            'suppliers',
            'clients',
            'categories',
            'brands',
            'packageTypes',
            'packingLists',
            'assignedProduct'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assignedProduct = session('assigned_product');

        if (!$assignedProduct || empty($assignedProduct)) {
            return back()->withErrors(['error' => 'No assigned products found in session'])->withInput();
        }
        
        // $detailIds = collect($assignedProduct)->pluck('inward_detail_id')->unique();
        // $detailIds = collect($assignedProduct)->flatMap(function ($product) {
        //                 $slots = is_array($product['selected_slots']) 
        //                     ? $product['selected_slots'] 
        //                     : json_decode($product['selected_slots'], true);

        //                 return collect($slots)->pluck('inward_detail_id')->filter();
        //             })->unique()->values();
        // $inwardIds = InwardDetail::whereIn('inward_detail_id', $detailIds)->pluck('inward_id')->unique();

        DB::beginTransaction();

        try {
            foreach ($assignedProduct as $product) {
                $selected_slots = is_array($product['selected_slots']) 
                    ? $product['selected_slots'] 
                    : json_decode($product['selected_slots'], true);

                $active_slots = array_filter($selected_slots, function ($slot) {
                        return empty($slot['is_assigned_deleted']) || $slot['is_assigned_deleted'] === false || $slot['is_assigned_deleted'] === "false";
                    });

                $totPalletQty = count($active_slots);
                $totPackageQty = array_reduce($active_slots, function ($sum, $slot) {
                    return $sum + (int)($slot['quantity'] ?? 0);
                }, 0);

                // Update Inward header
                $inward = Inward::findOrFail($product['inward_id']);
                $inward->fill([
                    'doc_date' => $request->doc_date,
                    'client_id' => $request->client_id ?? null,
                    'pallet_qty' => $totPalletQty,
                    'tot_package_qty' => $totPackageQty
                ]);
                $inward->save();
                
                foreach ($selected_slots as $selectedSlot)
                {
                    $inwardDetailId = $selectedSlot['inward_detail_id']??0;
                    
                    $packingListDetail = PackingListDetail::findOrFail($product['packing_list_detail_id']);

                    // Update & Delete
                    if($inwardDetailId>0) {
                        $inwardDetail = InwardDetail::with(['packingListDetail.product', 'packingListDetail.grnDetail', 'packingListDetail.packingList'])
                                                ->findOrFail($inwardDetailId);

                        // Check for full assignment flag
                        // if ($packingListDetail->grnDetail?->is_fully_assigned_to_cold_storage) {
                        //     throw new \Exception("Inward Detail ID {$inwardDetailId} is already assigned to cold storage.");
                        // }

                        // Update ProductMaster box capacity
                        ProductMaster::where('product_id', $product['product_id'])->update([
                            'box_capacity_per_full_pallet' => $product['package_qty_per_pallet']
                        ]);

                        // Update packing list detail
                        $packingListDetail->fill([
                            'package_qty_per_pallet' => $product['package_qty_per_pallet'],
                            'pallet_qty' => $product['pallet_qty']
                        ]);
                        $packingListDetail->save();

                        $slot = Slot::findOrFail($selectedSlot['slot_id']);
                        
                        // Update
                        if(!$selectedSlot['is_assigned_deleted']) { // Is not deleted

                            if ($slot->has_pallet) {

                                // Check if the pallet matches the assigned one
                                if (isset($selectedSlot['pallet_id']) && $slot->pallet_id == $selectedSlot['pallet_id']) {
                                    $existingPallet = Pallet::find($slot->pallet_id);
                                    if ($existingPallet) {
                                        $existingPallet->fill([
                                            'room_id' => $selectedSlot['room_id'],
                                            'rack_id' => $selectedSlot['rack_id'],
                                            'slot_id' => $selectedSlot['slot_id'],
                                            'capacity_unit_id' => $packingListDetail->product->ProductPackingID,
                                            'capacity' => $product['package_qty_per_pallet'],
                                            'client_id' => $request->client_id
                                        ]);
                                        $existingPallet->save();
                                    }

                                    // Slot::where('slot_id', $selectedSlot['slot_id']??0)->update([
                                    //     'status' => 'empty'
                                    // ]);
                                } else {
                                    // throw new \Exception("Slot ID {$slot->slot_id} already has a different pallet.");
                                }

                            } 

                            // Update Inward Detail
                            $inwardDetail->fill([
                                'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
                                'room_id' => $selectedSlot['room_id'],
                                'rack_id' => $selectedSlot['rack_id'],
                                'slot_id' => $selectedSlot['slot_id'],
                                'pallet_id' => $selectedSlot['pallet_id'] ?? ($pallet->pallet_id ?? null),
                                'quantity' => $selectedSlot['quantity']
                            ]);

                            $inwardDetail->save();
                        }
                        // Deleted
                        else if($selectedSlot['is_assigned_deleted']) { // Is deleted
                        
                            $inwardDetail = InwardDetail::find($selectedSlot['inward_detail_id'] ?? 0);

                            if ($inwardDetail) {
                                $inwardDetail->delete(); // will trigger deleting & deleted
                            }
                            // Pallet::where('pallet_id', $selectedSlot['pallet_id']??0)->delete();
                            // Slot::where('slot_id', $selectedSlot['slot_id']??0)->update([
                            //     'status' => 'empty'
                            // ]);
                        }
                    } 

                    //New Assign Products
                    else
                    {
                        $slot = Slot::findOrFail($selectedSlot['slot_id']);

                        // if ($slot->has_pallet) {
                        //     throw new \Exception("Slot ID {$slot->slot_id} already has a pallet.");
                        // }

                        $pallet = Pallet::create([
                            'room_id' => $selectedSlot['room_id'],
                            'rack_id' => $selectedSlot['rack_id'],
                            'slot_id' => $selectedSlot['slot_id'],
                            'capacity_unit_id' => $packingListDetail->product->ProductPackingID,
                            'capacity' => $product['package_qty_per_pallet'],
                            'weight' => $packingListDetail->packingList->weight_per_pallet,
                            'client_id' => $product['client_id'] ?? $request->client_id,
                            'is_active' => 1
                        ]);

                        InwardDetail::create([
                            'inward_id' => $inward->inward_id,
                            'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
                            'room_id' => $selectedSlot['room_id'],
                            'rack_id' => $selectedSlot['rack_id'],
                            'slot_id' => $selectedSlot['slot_id'],
                            'pallet_id' => $pallet->pallet_id,
                            'quantity' => $selectedSlot['quantity']
                        ]);
                    }
                }
            }

            DB::commit();
            session()->forget('assigned_product');

            return redirect()->route('admin.inventory.inward.index')->with('success', 'Items updated to inward successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to update product to inward.',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $inward = Inward::with('inwardDetails')->findOrFail($id);
            $inward->status = 'cancelled';
            $inward->save();

            $inward->inwardDetails->each(function ($detail) use ($status) {
                $detail->status = 'cancelled';
                $detail->save();
            });

            DB::commit();
            return response()->json(['message' => 'Inward cancelled successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to cancel inward.',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Assign the specified resource from storage.
     */
    public function assign(Request $request, string $packingListID, string $id)
    {
        $assignedProduct = session('assigned_product')??null;
        $productId = $request->input('product_id');
        $packageQty = $request->input('package_qty');
        $packageQtyPerPallet = $request->input('package_qty_per_pallet');
        $palletQty = $request->input('pallet_qty');

        $availableSlots = Slot::with(['stock','room','rack']) 
            ->whereIn('status', ['partial', 'empty'])
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
        $packingListDetail = PackingListDetail::with(['stocks','product','inward'])->findOrFail($id);
        $clients = Client::all();
        $defaultDate = Carbon::now()->format('Y-m-d');

        return view('admin.inventory.inward.assign', compact('packingList', 'rooms', 'racks', 'packingListID', 'packingListDetail', 'availableSlots', 'clients', 'defaultDate', 'productId', 'packageQty', 'palletQty', 'packageQtyPerPallet', 'assignedProduct'));
    }

    public function saveAssignedSlots(Request $request)
    {
        $data = $request->only([
            'packing_list_id',
            'packing_list_detail_id',
            'product_id',
            'package_qty',
            'package_qty_per_pallet',
            'pallet_qty',
            'selected_slots'
        ]);

        if(session()->get('assigned_product'))
            $assigned_product = session()->get('assigned_product');
        else
            $assigned_product = [];

        if(isset($assigned_product[$data['packing_list_detail_id']]['packing_list_id'])) {
            if($assigned_product[$data['packing_list_detail_id']]['packing_list_id'] != $data['packing_list_id']) {
                session()->forget('assigned_product');
                $assigned_product = [];
            }
        }

        if(!isset($assigned_product[$data['packing_list_detail_id']]))
            $assigned_product[$data['packing_list_detail_id']] = [];

        $assigned_product[$data['packing_list_detail_id']] = $data;

        session()->put('assigned_product', $assigned_product);

        // echo '<pre>'; print_r($assigned_product);

        return redirect()->route('admin.inventory.inward.create', [
            'id' => $request->packing_list_id
        ]);
    }

    /**
     * Re-Assign the specified resource from storage.
     */
    public function reassign(Request $request, string $inwardID, string $packingListDetailId)
    {
        // $assignedProduct = session('assigned_product')??null;
        $inward = Inward::findOrFail($inwardID);

        $productId = $request->input('product_id');
        $packageQty = $request->input('package_qty');
        $packageQtyPerPallet = $request->input('package_qty_per_pallet');
        $palletQty = $request->input('pallet_qty');

    
        $assignedProduct = (session('assigned_product')!=[])? session('assigned_product'): InwardDetail::with([
            'packingListDetail.product',
            'packingListDetail.packageType',
            'packingListDetail.grnDetail',
            'slot.rack.room' // Ensure these relationships exist
        ])
        ->where('inward_id', $inwardID)
        // ->where('packing_list_detail_id', $packingListDetailId)
        ->get()
        ->groupBy('packing_list_detail_id') // Grouping first
        ->map(function ($group) use($inwardID, $packageQtyPerPallet) {
            $first = $group->first();
            return [
                'inward_id' => $inwardID,
                'packing_list_id' => $first->packing_list_id,
                'packing_list_detail_id' => $first->packing_list_detail_id,
                'product_id' => optional($first->packingListDetail)->product_id,
                'package_qty' => $group->sum('quantity'),
                'package_qty_per_pallet' => optional($first->packingListDetail)->package_qty_per_pallet,
                'pallet_qty' => optional($first->packingListDetail)->pallet_qty,
                //'selected_slots' => $group->keyBy('slot_id')->map(function ($item) {
                'selected_slots' => collect($group)->keyBy('slot_id')->map(function ($item) use ($packageQtyPerPallet) {
                    // echo '<pre>'; print_r($item); echo '</pre>'; 
                    return [
                        'inward_detail_id' => $item['inward_detail_id'],
                        'slot_id' => $item['slot_id'],
                        'room_id' => optional($item)['room_id'],
                        'rack_id' => optional($item)['rack_id'],
                        'pallet_id' => optional($item)['pallet_id'],
                        'location' => optional($item->pallet)['pallet_position'],
                        'quantity' => $item['quantity'],
                        // 'quantity' => $packageQtyPerPallet,
                        'has_pallet' => true,
                        'is_assigned_deleted' => false,
                    ];
                })->toArray()
            ];
        })->toArray();
              
        $availableSlots = Slot::with(['stock','room','rack']) 
            ->whereIn('status', ['partial', 'empty', 'full'])
            ->get()
            ->map(function ($slot) use ($packageQtyPerPallet) {
                return [
                    'status' => $slot->status,
                    'slot_id' => $slot->slot_id,
                    'room_name' => $slot->room->name,
                    'rack_no' =>$slot->rack->rack_no,
                    'level_no' => $slot->level_no,
                    'depth_no' => $slot->depth_no,
                    // 'total' => $slot->pallet->pallet_capacity ?? 0,
                    'total' => $packageQtyPerPallet ?? 0,
                    'current' => $slot->pallet->current_pallet_capacity ?? 0
                ];
            });

        $packingList = PackingList::with('packingListDetails')->findOrFail($inward->packing_list_id);
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();
        $racks = Rack::with(['slots.pallet'])->get();
        $racks_array = Rack::with(['slots.pallet'])->get()->toArray();
        $packingListDetail = PackingListDetail::with(['stocks','product','inward'])->findOrFail($packingListDetailId);
        $clients = Client::all();
        $defaultDate = Carbon::now()->format('Y-m-d');
           
        return view('admin.inventory.inward.reassign', compact('inward', 'packingList', 'rooms', 'racks', 'racks_array', 'packingListDetail', 'availableSlots', 'clients', 'defaultDate', 'productId', 'packageQty', 'palletQty', 'packageQtyPerPallet', 'assignedProduct'));
    }

    public function saveReAssignedSlots(Request $request)
    {
        $data = $request->only([
            'inward_id',
            'packing_list_detail_id',
            'product_id',
            'package_qty',
            'package_qty_per_pallet',
            'pallet_qty',
            'selected_slots',
            'selected_products',
            'un_selected_products',
            'assigned_products'
        ]);
        
        if(session()->get('assigned_product'))
            $assigned_product = session()->get('assigned_product');
        else
            $assigned_product = [];

        // Decode selected_slots
        if(isset($assigned_product[$data['packing_list_detail_id']]['inward_id'])) {
            if($assigned_product[$data['packing_list_detail_id']]['inward_id'] != $data['inward_id']) {
                session()->forget('assigned_product');
                $assigned_product = [];
            }
        }

        // if(!isset($assigned_product[$data['packing_list_detail_id']]))
        //     $assigned_product[$data['packing_list_detail_id']] = [];

        $selected = json_decode($data['selected_products'], true) ?? [];
        $unselected = json_decode($data['un_selected_products'], true) ?? [];
        $assigned = json_decode($data['assigned_products'], true) ?? [];
      
        // Merge arrays (associative arrays by packing_list_detail_id, etc.)
        // $assigned_product = array_merge($unselected, $selected);
        $assigned_product = $assigned;

        // dd($assigned_product);
        session()->put('assigned_product', $assigned_product);

        return redirect()->route('admin.inventory.inward.edit', [
            'id' => $request->inward_id
        ]);
    }

    public function print($id)
    {
        $inward = Inward::findOrFail($id);
        $inwardDetails = InwardDetail::with('packingListDetail.packageType')
                                ->where('inward_id', $id)
                                ->get()
                                ->groupBy(function ($item) {
                                        return $item->packingListDetail->product_id . '_' . $item->packingListDetail->lot_no . '_' . $item->packingListDetail->expiry_date;
                                    })
                                ->map(function ($group) {
                                    return [
                                        'product_name' => $group->first()->packingListDetail->product->product_description,
                                        'batch_no' => $group->first()->packingListDetail->lot_no,
                                        'slot_positions' => $group->pluck('pallet.pallet_position')->unique()->implode(', '),
                                        'pallets' => $group->pluck('pallet.name')->unique()->implode(', '),
                                        'item_size_per_package' => $group->map(function ($item) {
                                                    return optional($item->packingListDetail)->item_size_per_package;
                                                })->filter()->unique()->implode(', '),
                                        'weight_per_unit' => $group->first()->packingListDetail->grnDetail->WeightPerUnit,
                                        'package_types' => $group->map(function ($item) {
                                                    return optional(optional($item->packingListDetail)->packageType)->description;
                                                })->filter()->unique()->implode(', '),
                                        'gw_per_package' => $group->first()->packingListDetail->gw_per_package,
                                        'nw_per_package' => $group->first()->packingListDetail->nw_per_package,
                                        'gw_with_pallet' => $group->first()->packingListDetail->gw_with_pallet,
                                        'nw_kg' => $group->first()->packingListDetail->nw_kg,
                                        'total_quantity' => $group->sum('quantity'),
                                        'package_qty_per_pallet' => $group->first()->packingListDetail->package_qty_per_pallet,
                                        'pallet_qty' => $group->pluck('pallet_id')->unique()->count()
                                    ];
                                });

        return view('admin.inventory.inward.print', compact('inward', 'inwardDetails'));
    }

    // public function changeStatus(Request $request)
    // {
    //     $inward_id = $request->input('inward_id');
    //     $status = $request->input('status');

    //     $inward = Inward::findOrFail($inward_id);
    //     $inward->status = $status;
    //     $inward->save();

    //     $inward->inwardDetails->each(function ($detail) use ($status) {
    //         $detail->status = $status;
    //         $detail->save();
    //     });
    //     // $inward_id = $request->input('inward_id');
    //     // $status = $request->input('status');
    //     // Inward::where('inward_id', $inward_id)->update(['status' => $status]);
        
    //     echo true;
    // }

    public function changeStatus(Request $request, InventoryStatusTransitionService $service)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        
        $inward_id = $request->input('inward_id');
        $newStatus = $request->input('status');

        $inward = Inward::with(['details', 'inwardDetails'])->findOrFail($inward_id);

        // Validate all detail transitions
        foreach ($inward->inwardDetails as $detail) {
            if (!$service->isAllowed('inward', $detail->status, $newStatus)) {
                return response()->json([
                    'message' => "Invalid transition from {$detail->status} to {$newStatus} on detail ID {$detail->inward_detail_id}"
                ], 422);
            }
        }

        // Apply to header (and cascade to details)
        $service->apply($inward, $newStatus);

        return response()->json(['message' => 'Status updated successfully']);
    }

}

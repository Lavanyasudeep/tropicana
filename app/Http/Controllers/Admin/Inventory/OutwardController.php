<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Inventory\PackingList;
use App\Models\Inventory\PackingListDetail;
use App\Models\Inventory\Outward;
use App\Models\Inventory\OutwardDetail;
use App\Models\Inventory\PickList;
use App\Models\Inventory\PickListDetail;
use App\Models\Inventory\Stock;
use App\Models\Master\Purchase\Supplier;
use App\Models\Client;
use App\Models\Master\General\Unit;
use App\Models\Master\Inventory\ProductCategory;
use App\Models\Master\Inventory\ProductMaster;
use App\Models\Master\General\Brand;
use App\Models\Master\General\Port;
use App\Models\Master\General\Status;

use App\Services\Inventory\InventoryStatusTransitionService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DataTables;
use Carbon\Carbon;

class OutwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $statuses = Status::select('status_name')->where('doc_type', 'outward')->get();

        if ($request->ajax()) {
            $query = Outward::with(['outwardDetails.pickListDetail.packingListDetail.product', 'outwardDetails.room', 'outwardDetails.rack', 'outwardDetails.slot', 'outwardDetails.pallet', 'client'])
                            ->where(function ($query) {
                                    $query->whereHas('outwardDetails', function ($q) {
                                        $q->groupBy('status'); 
                                    });
                                    // ->orWhereDoesntHave('outward'); // include if no outward exists
                                })
                            ->orderBy('created_at', 'desc');
            
            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if ($search != '') {
                        $query->where(function ($q) use ($search) {
                            $q->where('doc_no', 'like', "%{$search}%")
                                ->orWhereHas('client', function ($q2) use ($search) {
                                    $q2->where('client_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('outwardDetails.room', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('outwardDetails.rack', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('outwardDetails.slot', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('outwardDetails.pallet', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('outwardDetails.pickListDetail.packingListDetail.product', function ($q2) use ($search) {
                                    $q2->where('product_description', 'like', "%{$search}%");
                                })
                                ->orWhereHas('outwardDetails.pickListDetail.packingListDetail', function ($q2) use ($search) {
                                    $q2->where('lot_no', 'like', "%{$search}%");
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

                    if ($request->filled('status')) {
                        $query->whereHas('outwardDetails', function ($q) use ($request) {
                                $q->where('status', $request->status);
                            });
                    }
                })
                // ->addColumn('outward_items', function ($outward) {
                //     if ($outward->outwardDetails->isEmpty()) {
                //         return '<tr><td colspan="7" class="text-center">No Items</td></tr>';
                //     }

                //     $rows = '';
                //     foreach ($outward->outwardDetails as $item) {
                //         $rows .= '<tr>';
                //         $rows .= '<td>' . ($item->pickListDetail->packingListDetail->product->product_description ?? '-') . '</td>';
                //         $rows .= '<td>' . ($item->pickListDetail->packingListDetail->lot_no ?? '-') . '</td>';
                //         $rows .= '<td class="text-center">' . $item->quantity . '</td>';
                //         $rows .= '<td class="text-center">' . ($item->room->name ?? '-') . '</td>';
                //         $rows .= '<td class="text-center">' . ($item->rack->name ?? '-') . '</td>';
                //         $rows .= '<td class="text-center">' . ($item->slot->name ?? '-') . '</td>';
                //         $rows .= '<td class="text-center">' . ($item->pallet->pallet_no ?? '-') . '</td>';
                //         $rows .= '</tr>';
                //     }

                //     return '<table class="table table-sm mb-0">' .
                //             '<thead><tr><th>Product Name</th><th>Batch No</th><th>Qty</th><th>Room</th><th>Rack</th><th>Slot</th><th>Pallet</th></tr></thead>' .
                //             '<tbody>' . $rows . '</tbody></table>';
                // })
                ->editColumn('doc_date', function ($outward) {
                    return $outward->formatDate('doc_date');
                })
                ->addColumn('no_of_items', function ($outward) {
                    return $outward->outwardDetails->count();
                })
                ->addColumn('status', function ($outward) {
                    return ucfirst($outward->status);
                })
                ->addColumn('action', function ($outward) {
                    $act = '';
                    if($outward->status_list->contains('Created')) {
                        $act = '<a href="'.route('admin.inventory.outward.edit', $outward->outward_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    }
                    $act .= '<a href="' . route('admin.inventory.outward.print', $outward->outward_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.inventory.outward.view', $outward->outward_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    return $act;
                })
                ->rawColumns(['doc_no', 'outward_items', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.inventory.outward.index', compact('clients', 'statuses')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id=null)
    {
        $pickList = null;
        $pickedIds = [];

        if ($id) {
            $pickList = PickList::with('pickListDetails')->findOrFail($id);
            $pickedIds = $pickList->pickListDetails->pluck('packing_list_detail_id')->toArray();
        }

        $suppliers = Supplier::select('supplier_id', 'supplier_name')->get();
        $clients = Client::select('client_id', 'client_name')->get();
        $categories = ProductCategory::select('product_category_id', 'product_category_name')->orderBy('product_category_name')->limit(100)->get();
        $brands = Brand::select('brand_id', 'brand_name')->get();
        $products = ProductMaster::select('product_master_id', 'product_description')->orderBy('product_description')->limit(100)->get();
        $packageTypes = Unit::select('unit_id', 'description')->get();
        $ports = Port::select('port_id', 'port_name')->get();

        // Handle AJAX request for DataTable
        if ($request->ajax()) {
            // If client_id is not passed, return empty

            if ($request->client_id==null && !$request->filled('client_id')) {
                return datatables()->of(collect())->make(true);
            }

            $clientId = $request->input('client_id', $pickList->client_id??'');
           
            $query = Stock::with([
                        'room',
                        'rack',
                        'slot',
                        'pallet.products',
                        'product',
                        'grnDetail.grn',
                        'packingListDetail.packingList.client'
                    ])
                    ->whereHas('packingListDetail.packingList.client', fn($q) => $q->where('client_id', $clientId))
                    ->whereHas('packingListDetail.inwardDetail', function($q) use ($request) {
                        $q->where('status', 'finalized');
                    })
                    ->where('available_qty', '>',0)
                    ->select('cs_stock.*');

            if ($request->has('only_picked') && $request->only_picked == 1) {
                // CASE 1 → First show picked items
                $query->whereIn('room_id', $pickList->pickListDetails->pluck('room_id')->toArray())
                    ->whereIn('rack_id', $pickList->pickListDetails->pluck('rack_id')->toArray())
                    ->whereIn('slot_id', $pickList->pickListDetails->pluck('slot_id')->toArray())
                    ->whereIn('pallet_id', $pickList->pickListDetails->pluck('pallet_id')->toArray())
                    ->whereIn('packing_list_detail_id', $pickedIds);
            } 
            
            // Handle individual column filters
            if ($request->has('columns')) {
                $cols = $request->get('columns');

                if (!empty($cols[1]['search']['value'])) {
                    $query->whereHas('product', fn($q) =>
                        $q->where('product_description', 'like', '%' . $cols[1]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[2]['search']['value'])) {
                    $query->where('batch_no', 'like', '%' . $cols[2]['search']['value'] . '%');
                }

                if (!empty($cols[4]['search']['value'])) {
                    $query->whereHas('room', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[4]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[5]['search']['value'])) {
                    $query->whereHas('rack', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[5]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[6]['search']['value'])) {
                    $query->whereHas('slot', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[6]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[7]['search']['value'])) {
                    $query->whereHas('pallet', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[7]['search']['value'] . '%')
                    );
                }

            }

            // Return filtered data
            return DataTables::eloquent($query)
                ->addColumn('pick', function ($row) use ($pickList) {
                    $detail = $pickList?->picklistDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->where('packing_list_detail_id', $row->packing_list_detail_id)
                        ->first();

                    $existing = $detail !== null;
                    $checked = ($existing) ? 'checked' : '';
                    return '<input type="checkbox" class="pick-check" data-package-qty="' . $row->available_qty . '" name="picks[]" data-pallet-id="' . $row->pallet_id . '" data-weight-per-pallet="' . $row->packingListDetail->packingList->weight_per_pallet . '" data-packing-list-detail-id="' . $row->packing_list_detail_id . '" ' . $checked . '>';
                })
                ->addColumn('slot_position', function($row) { 
                    $slot_no = $row->room->name; 
                    $slot_no .= '-'.$row->rack->name; 
                    $slot_no .= '-'.$row->slot->level_no;
                    $slot_no .= '-'.$row->slot->depth_no;
                    return $slot_no;
                })
                ->addColumn('product_name', fn($row) => $row->product->product_description ?? '-')
                ->addColumn('batch_no', fn($row) => $row->batch_no ?? '-')
                ->addColumn('size', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->item_size_per_package: '';
                })
                ->addColumn('package_type', function ($row) {
                    return $row->packingListDetail->packageType? $row->packingListDetail->packageType?->description : '';
                })
                ->addColumn('gw_per_package', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->gw_per_package : '';
                })
                ->addColumn('nw_per_package', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->nw_per_package : '';
                })
                ->addColumn('gw_with_pallet', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->gw_with_pallet : '';
                })
                ->addColumn('nw_kg', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->nw_kg : '';
                })
                // ->addColumn('client_name', fn($row) =>
                //     $row->packingListDetail->packingList->client->client_name ?? '-'
                // )
                ->addColumn('pick_qty', function ($row) use ($pickList) {
                    $detail = $pickList?->picklistDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->where('packing_list_detail_id', $row->packing_list_detail_id)
                        ->first();

                    return $detail?->quantity ?? 0;
                    //return $pickList?->picklistDetails->firstWhere('packing_list_detail_id', $row->packing_list_detail_id)?->quantity ?? 0;
                })
                ->rawColumns(['pick'])
                ->make(true);
        }

        return view('admin.inventory.outward.create', compact('pickList', 'suppliers', 'clients', 'packageTypes', 'categories', 'brands', 'ports'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id= null)
    {
        // $request->validate([
        //     'product_master_id'      => 'required|integer',
        //     'grn_detail_id'          => 'required|integer',
        //     'box_capacity_per_pallet'=> 'required',
        //     'assignments'            => 'required|array|min:1',
        // ]);

        $detailIds = collect($request->selected_items)->pluck('packing_list_detail_id');
        
        $packingListIds = PackingListDetail::whereIn('packing_list_detail_id', $detailIds)
            ->pluck('packing_list_id')
            ->unique();

        DB::beginTransaction();

        try {
            // Update the PickList main fields

            $pickList = PickList::UpdateOrCreate(
                [
                    'picklist_id' => $id
                ],
                [
                'doc_date' => $request->doc_date,
                // 'dispatch_date' => $request->dispatch_date,
                // 'dispatch_location' => $request->dispatch_location,
                'client_id' => $request->client_id,
                'contact_name' => $request->contact_name ?? null,
                'contact_address' => $request->contact_address ?? null
            ]);

            // Check or Create cs_outward
            $outward = Outward::UpdateOrCreate(
                [
                    'picklist_id' => $id??$pickList->picklist_id
                ],
                [
                    'picklist_id' => $id??$pickList->picklist_id,
                    'doc_date'    => $request->doc_date,
                    'client_id' => $request->client_id,
                    'contact_name' => $request->contact_name ?? null,
                    'contact_address' => $request->contact_address ?? null,
                    'tot_package_qty' => $request->tot_package_qty,
                    'vehicle_no' => $request->vehicle_no,
                    'driver' => $request->driver
                ]
            );

            // Existing picked items in DB
            $existingPickListDetails = PickListDetail::where('picklist_id', $id??$pickList->picklist_id)->get();

            // 1️⃣ Delete removed items (unchecked now)
            $existingToDelete = $existingPickListDetails
                ->whereNotIn('packing_list_detail_id', $detailIds);

            // foreach ($existingToDelete as $toDelete) {
            //     $toDelete->status = 'created';
            //     $toDelete->save();
            // }
            
            $palletQty = 0;
            $totPackageQty = 0;
          
            foreach ($request->selected_items as $i=>$item) {
                $packingListDtl = PackingListDetail::findOrFail($item['packing_list_detail_id']);
                
                $existingDetail = $existingPickListDetails
                    ->firstWhere('packing_list_detail_id', $item['packing_list_detail_id']);
                
                $stock = Stock::where([
                        'pallet_id' => $item['pallet_id'],
                        'product_id' => $packingListDtl->product_id,
                        'batch_no' => $packingListDtl->lot_no,
                        'expiry_date' => $packingListDtl->expiry_date,
                        'packing_list_detail_id' => $item['packing_list_detail_id'],
                    ])
                    ->firstOrFail();

                if ($item['pick_qty'] > $stock->available_qty) {
                    throw new \Exception("Pick quantity for {$packingListDtl->product->product_description} exceeds available balance.");
                }

                $pickListDtl = PickListDetail::UpdateOrCreate([
                    'packing_list_detail_id' => $packingListDtl->packing_list_detail_id,
                    'room_id' => $stock->room_id,
                    'rack_id' => $stock->rack_id,
                    'slot_id' => $stock->slot_id,
                    'pallet_id' => $stock->pallet_id
                ],
                    [
                    'quantity' => $item['pick_qty'],
                    'picklist_id' => $pickList->picklist_id
                ]);
               
                OutwardDetail::create([
                    'outward_id'         => $outward->outward_id,
                    'picklist_detail_id'=> $pickListDtl->picklist_detail_id,
                    'room_id'           => $pickListDtl->room_id,
                    'rack_id'           => $pickListDtl->rack_id,
                    'slot_id'           => $pickListDtl->slot_id,
                    'pallet_id'         => $pickListDtl->pallet_id,
                    'quantity'          => $item['pick_qty']
                ]);
                
                $palletQty++;
                $totPackageQty += $item['package_qty'];
            }

            // Update total quantity in cs_outward
            $outward->pallet_qty = $palletQty;
            $pickList->tot_package_qty = $totPackageQty;
            $outward->save();

            $pickList->pallet_qty = $palletQty;
            $pickList->tot_package_qty = $totPackageQty;
            $pickList->save();

            DB::commit();
            
            return redirect()->route('admin.inventory.outward.index')->with('success', 'Items submitted to outward successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to submit product to outward', 'details' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $outward = Outward::with(['outwardDetails.statusUpdates.creator'])->findOrFail($id);
        $outwardDetails = OutwardDetail::with('pickListDetail.packingListDetail.packageType')
                                ->where('outward_id', $id)
                                ->when($outward->status_list->contains('Cancelled'), fn($q) => $q->withTrashed())
                                ->get();

        $transitions = config('status_transitions.outward');
        $service = new InventoryStatusTransitionService($transitions);

        $statuses = $outward->outwardDetails->pluck('status')->filter()->unique();

        $nextOptions = collect();

        foreach ($statuses as $status) {
            $nextOptions = $nextOptions->merge(
                $service->getNextAllowed('inward', $status)
            );
        }

        $nextOptions = $nextOptions->unique()->values();

        return view('admin.inventory.outward.view', compact('outward', 'outwardDetails', 'nextOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        $outward = Outward::with('pickList', 'outwardDetails.pickListDetail')->findOrFail($id);  
        $outwardIds = $outward->outwardDetails->pluck('outward_detail_id')->toArray();
        
        $pickList = PickList::with('pickListDetails')->findOrFail($outward->picklist_id);
        $pickedIds = $pickList->pickListDetails->pluck('packing_list_detail_id')->toArray();
       
        $suppliers = Supplier::select('supplier_id', 'supplier_name')->get();
        $clients = Client::select('client_id', 'client_name')->get();
        $categories = ProductCategory::select('product_category_id', 'product_category_name')->orderBy('product_category_name')->limit(100)->get();
        $brands = Brand::select('brand_id', 'brand_name')->get();
        $products = ProductMaster::select('product_master_id', 'product_description')->orderBy('product_description')->limit(100)->get();
        $packageTypes = Unit::select('unit_id', 'description')->get();
        $ports = Port::select('port_id', 'port_name')->get();
       
        // Handle AJAX request for DataTable
        if ($request->ajax()) {
            // If client_id is not passed, return empty

            if ($request->client_id==null && !$request->filled('client_id')) {
                return datatables()->of(collect())->make(true);
            }

            $clientId = $request->input('client_id', $outward->client_id);
           
            $query = Stock::with([
                        'room',
                        'rack',
                        'slot',
                        'pallet.products',
                        'product',
                        'grnDetail.grn',
                        'packingListDetail.packingList.client'
                    ])
                    ->whereHas('packingListDetail.packingList.client', fn($q) => $q->where('client_id', $clientId))
                    ->whereHas('packingListDetail.inwardDetail', function($q) use ($request) {
                        $q->where('status', 'finalized');
                    })
                    ->select('cs_stock.*');
            
            if ($request->has('only_picked') && $request->only_picked == 1) {
                // CASE 1 → First show picked items
                $query->whereIn('room_id', $pickList->pickListDetails->pluck('room_id')->toArray())
                    ->whereIn('rack_id', $pickList->pickListDetails->pluck('rack_id')->toArray())
                    ->whereIn('slot_id', $pickList->pickListDetails->pluck('slot_id')->toArray())
                    ->whereIn('pallet_id', $pickList->pickListDetails->pluck('pallet_id')->toArray())
                    ->whereIn('packing_list_detail_id', $pickedIds);
            } 

            // Handle individual column filters
            if ($request->has('columns')) {
                $cols = $request->get('columns');

                if (!empty($cols[1]['search']['value'])) {
                    $query->whereHas('room', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[1]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[2]['search']['value'])) {
                    $query->whereHas('rack', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[2]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[3]['search']['value'])) {
                    $query->whereHas('slot', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[3]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[4]['search']['value'])) {
                    $query->whereHas('pallet', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[4]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[5]['search']['value'])) {
                    $query->whereHas('product', fn($q) =>
                        $q->where('product_description', 'like', '%' . $cols[5]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[6]['search']['value'])) {
                    $query->where('batch_no', 'like', '%' . $cols[6]['search']['value'] . '%');
                }
            }

            // Handle individual column filters
            if ($request->has('columns')) {
                $cols = $request->get('columns');

                if (!empty($cols[1]['search']['value'])) {
                    $query->whereHas('product', fn($q) =>
                        $q->where('product_description', 'like', '%' . $cols[1]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[2]['search']['value'])) {
                    $query->where('batch_no', 'like', '%' . $cols[2]['search']['value'] . '%');
                }

                if (!empty($cols[4]['search']['value'])) {
                    $query->whereHas('room', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[4]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[5]['search']['value'])) {
                    $query->whereHas('rack', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[5]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[6]['search']['value'])) {
                    $query->whereHas('slot', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[6]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[7]['search']['value'])) {
                    $query->whereHas('pallet', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[7]['search']['value'] . '%')
                    );
                }

            }

            // Return filtered data
            return DataTables::eloquent($query)
                ->addColumn('pick', function ($row) use ($outward) {
                    $detail = $outward?->outwardDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->filter(function ($outwardDetail) use ($row) {
                            return $outwardDetail->pickListDetail
                                && $outwardDetail->pickListDetail->packing_list_detail_id == $row->packing_list_detail_id;
                        })
                        ->first();

                    $existing = $detail !== null;
                    $checked = ($existing) ? 'checked' : '';

                    return '<input type="checkbox" class="pick-check" 
                            data-package-qty="' . $row->out_qty . '" 
                            name="picks[]" 
                            data-pallet-id="' . $row->pallet_id . '"
                            data-outward-detail-id="' . ($detail?->outward_detail_id ?? '') . '" 
                            data-packing-list-detail-id="' . $row->packing_list_detail_id . '" 
                            ' . $checked . '>';
                })
                ->addColumn('product_name', fn($row) => $row->product->product_description ?? '-')
                ->addColumn('batch_no', fn($row) => $row->batch_no ?? '-')
                ->addColumn('size', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->item_size_per_package: '';
                })
                ->addColumn('package_type', function ($row) {
                    return $row->packingListDetail->packageType? $row->packingListDetail->packageType?->description : '';
                })
                ->addColumn('slot_position', function($row) { 
                    $slot_no = $row->room->name; 
                    $slot_no .= '-'.$row->rack->name; 
                    $slot_no .= '-'.$row->slot->level_no;
                    $slot_no .= '-'.$row->slot->depth_no;
                    return $slot_no;
                })
                ->addColumn('gw_per_package', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->gw_per_package : '';
                })
                ->addColumn('nw_per_package', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->nw_per_package : '';
                })
                ->addColumn('gw_with_pallet', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->gw_with_pallet : '';
                })
                ->addColumn('nw_kg', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->nw_kg : '';
                })
                // ->addColumn('client_name', fn($row) =>
                //     $row->packingListDetail->packingList->client->client_name ?? '-'
                // )
                ->addColumn('pick_qty', function ($row) use ($outward) {
                    $detail = $outward?->outwardDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->filter(function ($outwardDetail) use ($row) {
                            return $outwardDetail->pickListDetail
                                && $outwardDetail->pickListDetail->packing_list_detail_id == $row->packing_list_detail_id;
                        })
                        ->first();

                    return $detail?->quantity ?? 0;
                })
                ->rawColumns(['pick'])
                ->make(true);
        }

        return view('admin.inventory.outward.edit', compact('outward', 'suppliers', 'clients', 'packageTypes', 'categories', 'brands', 'ports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'product_master_id'      => 'required|integer',
        //     'grn_detail_id'          => 'required|integer',
        //     'box_capacity_per_pallet'=> 'required',
        //     'assignments'            => 'required|array|min:1',
        // ]);

        $detailIds = collect($request->selected_items)->pluck('packing_list_detail_id');
        $palletIds = collect($request->selected_items)->pluck('pallet_id');
        
        $packingListIds = PackingListDetail::whereIn('packing_list_detail_id', $detailIds)
            ->pluck('packing_list_id')
            ->unique();

        DB::beginTransaction();

        try {
            // Update the PickList main fields
            $outward = Outward::findOrFail($id);

            $pickList = PickList::UpdateOrCreate(
                [
                    'picklist_id' => $outward->picklist_id
                ],
                [
                    'doc_date' => $request->doc_date,
                    // 'dispatch_date' => $request->dispatch_date,
                    // 'dispatch_location' => $request->dispatch_location,
                    'client_id' => $request->client_id,
                    'contact_name' => $request->contact_name ?? null,
                    'contact_address' => $request->contact_address ?? null
                ]);

            // Check or Create cs_outward
            $outward = Outward::UpdateOrCreate(
                [
                    'outward_id' => $id,
                    'picklist_id' => $pickList->picklist_id
                ],
                [
                    'picklist_id' => $pickList->picklist_id,
                    'doc_date'    => $request->doc_date,
                    'client_id' => $request->client_id,
                    'contact_name' => $request->contact_name ?? null,
                    'contact_address' => $request->contact_address ?? null,
                    'vehicle_no' => $request->vehicle_no,
                    'driver' => $request->driver
                ]
            );
            // Existing outward items in DB
            $existingOutwardDetails = OutwardDetail::where('outward_id', $id)->get();

            // Existing picked items in DB
            $existingPickListDetails = PickListDetail::where('picklist_id', $outward->picklist_id)->get();

            // 1️⃣ Delete removed items (unchecked now)
            $existPickToDelete = $existingPickListDetails
                // ->whereNotIn('packing_list_detail_id', $detailIds)
                ->whereNotIn('pallet_id', $palletIds);

            foreach ($existPickToDelete as $toDelete) {
                // $existingOutwardDetails->where('picklist_detail_id', $toDelete->picklist_detail_id)->delete();
                OutwardDetail::where([
                        'outward_id' => $id,
                        'picklist_detail_id' => $toDelete->picklist_detail_id
                    ])->chunk(100, function ($outwardDetails) {
                        foreach ($outwardDetails as $detail) {
                            $detail->delete();
                        }
                    });
            }

            $palletQty = 0;
            $totPackageQty = 0;
            
            if(isset($request->selected_items)) {
                 foreach ($request->selected_items as $i=>$item) {
                    $packingListDtl = PackingListDetail::findOrFail($item['packing_list_detail_id']);

                    $existingDetail = $existingPickListDetails
                        ->firstWhere('packing_list_detail_id', $item['packing_list_detail_id']);
                    
                    $stock = Stock::where([
                            'pallet_id' => $item['pallet_id'],
                            'product_id' => $packingListDtl->product_id,
                            'batch_no' => $packingListDtl->lot_no,
                            'expiry_date' => $packingListDtl->expiry_date,
                            'packing_list_detail_id' => $item['packing_list_detail_id'],
                        ])->firstOrFail();

                    // if ($item['pick_qty'] > $stock->available_qty) {
                    //     throw new \Exception("Pick quantity for {$packingListDtl->product->product_description} exceeds available balance.");
                    // }

                    $pickListDtl = PickListDetail::UpdateOrCreate([
                            'packing_list_detail_id' => $packingListDtl->packing_list_detail_id,
                            'room_id' => $stock->room_id,
                            'rack_id' => $stock->rack_id,
                            'slot_id' => $stock->slot_id,
                            'pallet_id' => $stock->pallet_id
                        ],
                        [
                        'quantity' => $item['pick_qty'],
                        'picklist_id' => $pickList->picklist_id,
                    ]);

                    OutwardDetail::updateOrCreate(
                        [
                            'picklist_detail_id'  => $pickListDtl->picklist_detail_id,
                            'room_id'     => $pickListDtl->room_id,
                            'rack_id'     => $pickListDtl->rack_id,
                            'slot_id'     => $pickListDtl->slot_id,
                            'pallet_id'   => $pickListDtl->pallet_id
                        ],
                        [
                            'outward_id'  => $id,
                            'quantity'    => $item['pick_qty']
                        ]
                    );
                    
                    $totPackageQty += $item['package_qty'];
                    $palletQty++;
                }

                // Update total quantity in cs_outward
                $outward->pallet_qty = $palletQty;
                $outward->tot_package_qty = $totPackageQty;
                $outward->save();

                $pickList->pallet_qty = $palletQty;
                $pickList->tot_package_qty = $totPackageQty;
                $pickList->save();
            }
           
            DB::commit();
            
            return redirect()->route('admin.inventory.outward.index')->with('success', 'Outward updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update outward', 'details' => $e->getMessage()])->withInput();
        }
    }

    public function print($id)
    {
        $outward = Outward::findOrFail($id);
        $outwardDetails = OutwardDetail::with('pickListDetail.packingListDetail.packageType')->where('outward_id', $id)->get();

        return view('admin.inventory.outward.print', compact('outward', 'outwardDetails'));
    }

    // public function changeStatus(Request $request)
    // {
    //     $outward_id = $request->input('outward_id');
    //     $status = $request->input('status');

    //     $outward = Outward::findOrFail($outward_id);
    //     $outward->status = $status;
    //     $outward->save();

    //     $outward->updateStatus();
        
    //     echo true;
    // }

    public function changeStatus(Request $request, InventoryStatusTransitionService $service)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $newStatus = $request->input('status');
        $outward_id = $request->input('outward_id');

        $outward = Outward::with(['details', 'outwardDetails'])->findOrFail($outward_id);

        // Validate all detail transitions
        foreach ($outward->outwardDetails as $detail) {
            if (!$service->isAllowed('inward', $detail->status, $newStatus)) {
                return response()->json([
                    'message' => "Invalid transition from {$detail->status} to {$newStatus} on detail ID {$detail->outward_detail_id}"
                ], 422);
            }
        }

        // Apply transition
        $service->apply($outward, $newStatus);

        // return response()->json(['message' => 'Status updated successfully', 'status' => $outward->status]);
        return response()->json(['message' => 'Status updated successfully']);
        // echo true;
    }
}

<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Inventory\PickList;
use App\Models\Inventory\PickListDetail;
use App\Models\Inventory\Stock;
use App\Models\Client;
use App\Models\Master\Inventory\ProductCategory;
use App\Models\Master\General\Brand;
use App\Models\Master\Inventory\ProductMaster;
use App\Models\Inventory\PackingListDetail;
use App\Models\Master\General\Status;

use App\Services\Inventory\InventoryStatusTransitionService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DataTables;
use Carbon\Carbon;

class PickListController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $clients = Client::all();
        $statuses = Status::select('status_name')->where('doc_type', 'picklist')->get();
        
        if ($request->ajax()) {
            //$query = PickList::with(['pickListDetails.packingListDetail.product', 'pickListDetails.room', 'pickListDetails.rack', 'pickListDetails.slot', 'pickListDetails.pallet', 'client'])
            $query = PickList::with(['pickListDetails.packingListDetail.product', 'client'])
                                ->where(function ($query) {
                                    $query->whereHas('pickListDetails', function ($q) {
                                        $q->groupBy('status'); 
                                    });
                                    // ->orWhereDoesntHave('outward'); // include if no outward exists
                                })
                                ->orderBy('created_at', 'desc');
            // ->where(function ($query) {
            //     $query->whereHas('outward', function ($q) {
            //         $q->whereNull('status'); // only include if status is NULL
            //     })
            //     ->orWhereDoesntHave('outward'); // include if no outward exists
            // });

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if ($search != '') {
                        $query->where(function ($q) use ($search) {
                            $q->where('doc_no', 'like', "%{$search}%")
                                ->orWhereHas('client', function ($q2) use ($search) {
                                    $q2->where('client_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('pickListDetails.room', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('pickListDetails.rack', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('pickListDetails.slot', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('pickListDetails.pallet', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('pickListDetails.packingListDetail.product', function ($q2) use ($search) {
                                    $q2->where('product_description', 'like', "%{$search}%");
                                })
                                ->orWhereHas('pickListDetails.packingListDetail', function ($q2) use ($search) {
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
                        $query->whereHas('pickListDetails', function ($q) use ($request) {
                                $q->where('status', $request->status);
                            });
                    }
                })
                // ->addColumn('picked_items', function ($pickList) {
                //     if ($pickList->pickListDetails->isEmpty()) {
                //         return '<tr><td colspan="7" class="text-center">No Picked Items</td></tr>';
                //     }

                //     $rows = '';
                //     foreach ($pickList->pickListDetails as $item) {
                //         $rows .= '<tr>';
                //         $rows .= '<td>' . ($item->packingListDetail->product->product_description ?? '-') . '</td>';
                //         $rows .= '<td>' . ($item->packingListDetail->lot_no ?? '-') . '</td>';
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
                ->editColumn('doc_date', function ($pickList) {
                    return $pickList->formatDate('doc_date');
                })
                ->addColumn('no_of_items', function ($pickList) {
                    return $pickList->pickListDetails->count();
                })
                ->addColumn('picked_qty', function ($pickList) {
                    return $pickList->pickListDetails->sum('quantity');
                })
                ->addColumn('status', function ($pickList) {
                    return ucfirst($pickList->status);
                })
                ->addColumn('action', function ($pickList) {
                    $act = '';
                    // dd($pickList->outward->status_list->last());
                    if(optional($pickList->status_list)->last() == 'Created') {
                        $act = '<a href="'.route('admin.inventory.pick-list.edit', $pickList->picklist_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    }
                    $act .= '<a href="' . route('admin.inventory.pick-list.print', $pickList->picklist_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '<a href="' . route('admin.inventory.pick-list.view', $pickList->picklist_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    if (
                        optional($pickList?->status_list)->last() == 'Finalized' ||
                            optional($pickList->outward?->status_list)->last() == 'Cancelled' ||
                            optional($pickList->outward?->status_list)->last() == 'Rejected' && !$pickList->outward()->exists()
                    ) {
                        $act .= '<a href="' . route('admin.inventory.outward.create', $pickList->picklist_id) . '" class="btn btn-sm btn-out submit-btn"><i class="fas fa-arrow-right"></i> Out</a>';
                    }
                    return $act;
                })
                ->rawColumns(['doc_no', 'picked_items', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.inventory.pick-list.index', compact('clients', 'statuses')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Load dropdown data for the form
        $clients = Client::select('client_id', 'client_name')->get();
        $categories = ProductCategory::select('product_category_id', 'product_category_name')->orderBy('product_category_name')->limit(100)->get();
        $brands = Brand::select('brand_id', 'brand_name')->get();
        $products = ProductMaster::select('product_master_id', 'product_description')->orderBy('product_description')->limit(100)->get();

        // Handle AJAX request for DataTable
        if ($request->ajax()) {
            // If client_id is not passed, return empty
            if (!$request->filled('client_id')) {
                return datatables()->of(collect())->make(true);
            }

            $query = Stock::with([
                    'room',
                    'rack',
                    'slot',
                    'pallet.products',
                    'product',
                    'grnDetail.grn',
                    'packingListDetail.packingList.client' // include client directly
                ])
                ->where('available_qty', '>', 0)
                ->whereHas('packingListDetail.inwardDetail', function($q) use ($request) {
                    $q->where('status', 'finalized');
                })
                ->whereHas('packingListDetail.packingList.client', function($q) use ($request) {
                    $q->where('client_id', $request->client_id);
                })
                ->select('cs_stock.*');

            // Handle individual column filters
            if ($request->has('columns')) {
                $cols = $request->get('columns');

                if (!empty($cols[1]['search']['value'])) {
                    // $query->whereHas('room', fn($q) =>
                    //     $q->where('name', 'like', '%' . $cols[1]['search']['value'] . '%')
                    // );

                    $search = strtolower($cols[1]['search']['value']); // force input to lowercase
                    $parts = explode('-', $search);

                    $query->where(function ($q) use ($parts) {
                        foreach ($parts as $part) {
                            $matched = false;

                            // Match Level: L4, l4, L
                            if (preg_match('/^l(\d*)$/', $part, $m)) {
                                $matched = true;
                                $level = $m[1] ?? '';
                                $q->whereHas('slot', function ($qs) use ($level) {
                                    $qs->whereRaw('LOWER(level_no) like ?', ["%$level%"]);
                                });
                            }

                            // Match Depth: D1, d1, D
                            elseif (preg_match('/^d(\d*)$/', $part, $m)) {
                                $matched = true;
                                $depth = $m[1] ?? '';
                                $q->whereHas('slot', function ($qs) use ($depth) {
                                    $qs->whereRaw('LOWER(depth_no) like ?', ["%$depth%"]);
                                });
                            }

                            // Match Rack: R2, r2
                            elseif (str_starts_with($part, 'r')) {
                                $matched = true;
                                $q->whereHas('rack', function ($qr) use ($part) {
                                    $qr->whereRaw('LOWER(name) like ?', ["%$part%"]);
                                });
                            }

                            // Fallback to Room
                            if (!$matched) {
                                $q->whereHas('room', function ($qr) use ($part) {
                                    $qr->whereRaw('LOWER(name) like ?', ["%$part%"]);
                                });
                            }
                        }
                    });
                }

                // if (!empty($cols[2]['search']['value'])) {
                //     $query->whereHas('rack', fn($q) =>
                //         $q->where('name', 'like', '%' . $cols[2]['search']['value'] . '%')
                //     );
                // }

                // if (!empty($cols[3]['search']['value'])) {
                //     $query->whereHas('slot', fn($q) =>
                //         $q->where('name', 'like', '%' . $cols[3]['search']['value'] . '%')
                //     );
                // }

                if (!empty($cols[2]['search']['value'])) {
                    $query->whereHas('pallet', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[4]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[3]['search']['value'])) {
                    $query->whereHas('product', fn($q) =>
                        $q->where('product_description', 'like', '%' . $cols[5]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[4]['search']['value'])) {
                    $query->where('batch_no', 'like', '%' . $cols[6]['search']['value'] . '%');
                }
            }

            // Return filtered data
            return DataTables::eloquent($query)
                ->addColumn('pick', function ($row) {
                   return '<input type="checkbox" class="pick-check" data-package-qty="' . $row->available_qty . '" name="picks[]" data-pallet-id="' . $row->pallet_id . '" data-packing-list-detail-id="' . $row->packing_list_detail_id . '">';
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
                // ->addColumn('client_name', fn($row) =>
                //     return optional($row->packingListDetail?->packingList?->client)->client_name ?? '-';
                // )
                ->rawColumns(['pick'])
                ->make(true);
        }

        // For normal view rendering
        return view('admin.inventory.pick-list.create', compact('products', 'clients', 'brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate main form inputs
        $validated = $request->validate([
            'doc_date' => 'required|date',
            'dispatch_date' => 'required|date|after_or_equal:doc_date',
            // 'dispatch_location' => 'required|string|max:100',
            'client_id' => 'required|exists:cs_client,client_id',
            // 'contact_name' => 'nullable|string|max:100',
            // 'contact_address' => 'nullable|string|max:255',
            // 'total_qty' => 'required|numeric|min:1',
            'selected_items' => 'required|array|min:1',
            // 'selected_items.*.stock_id' => 'required|exists:cs_stock,stock_id',
            'selected_items.*.packing_list_detail_id' => 'required|exists:cs_packing_list_detail,packing_list_detail_id',
            // 'selected_items.*.pick_qty' => 'required|numeric|min:0',
        ]);

        // Calculate total quantity from selected items
        $totalPickedQty = collect($request->selected_items)->sum('pick_qty');
        $palletQty = 0;

        // Check if total picked qty matches expected
        if ((float) $request->total_qty !== (float) $totalPickedQty) {
            return back()->withErrors(['selected_items' => 'Total picked quantity must match the total quantity to pick.'])->withInput();
        }

        $detailIds = collect($request->selected_items)->pluck('packing_list_detail_id');

        try {
            DB::beginTransaction();

            // Create PickList master record
            $pickList = PickList::create([
                'doc_date' => $request->doc_date,
                'dispatch_date' => $request->dispatch_date,
                'dispatch_location' => $request->dispatch_location,
                'client_id' => $request->client_id,
                'contact_name' => $request->contact_name ?? null,
                'contact_address' => $request->contact_address ?? null,
                // 'tot_package_qty' => $request->total_qty
                'tot_package_qty' => $request->totalPickedQty
            ]);
        
            // Loop through selected items to create details
            foreach ($request->selected_items as $item) {
                $packingListDtl = PackingListDetail::findOrFail($item['packing_list_detail_id']);
                $stock = Stock::where([
                            'pallet_id' => $item['pallet_id'],
                            'product_id' => $packingListDtl->product_id,
                            'batch_no' => $packingListDtl->lot_no,
                            'expiry_date' => $packingListDtl->expiry_date,
                            'packing_list_detail_id' => $packingListDtl->packing_list_detail_id
                        ])->firstOrFail();

                if ($item['pick_qty'] > $stock->available_qty) {
                    throw new \Exception("Pick quantity for {$packingListDtl->product->product_description} exceeds available balance.");
                }

                PickListDetail::create([
                    'picklist_id' => $pickList->picklist_id,
                    'packing_list_detail_id' => $packingListDtl->packing_list_detail_id,
                    'quantity' => $item['pick_qty'],
                    'room_id' => $stock->room_id,
                    'rack_id' => $stock->rack_id,
                    'slot_id' => $stock->slot_id,
                    'pallet_id' => $stock->pallet_id
                ]);

                $palletQty++;
            }

            $pickList->pallet_qty = $palletQty;
            $pickList->save();

            DB::commit();

            return redirect()->route('admin.inventory.pick-list.index')->with('success', 'PickList created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create PickList: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pickList = PickList::with(['pickListDetails.statusUpdates.creator', 'pickListDetails.packingListDetail.packageType'])
                            ->findOrFail($id);

        $pickListDetails = $pickList->pickListDetails;

        $currentStatuses = $pickListDetails->pluck('status')->unique()->toArray();
        $currentStatus = $pickListDetails->pluck('status')->unique()->values()->first();

        $transitions = config('status_transitions.picklist'); // assuming you define it
        $service = new InventoryStatusTransitionService($transitions);

        $statuses = $pickListDetails->pluck('status')->filter()->unique();

        $nextOptions = collect();

        foreach ($statuses as $status) {
            $nextOptions = $nextOptions->merge(
                $service->getNextAllowed('inward', $status)
            );
        }

        $nextOptions = $nextOptions->unique()->values();

        return view('admin.inventory.pick-list.view', compact('pickList', 'pickListDetails', 'nextOptions', 'currentStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        $pickList = PickList::with('pickListDetails')->findOrFail($id);
        $clients = Client::select('client_id', 'client_name')->get();
        $categories = ProductCategory::select('product_category_id', 'product_category_name')->orderBy('product_category_name')->limit(100)->get();
        $brands = Brand::select('brand_id', 'brand_name')->get();
        $products = ProductMaster::select('product_master_id', 'product_description')->orderBy('product_description')->limit(100)->get();

        // Build map of picked items for faster lookup
        $pickedIds = $pickList->pickListDetails->pluck('packing_list_detail_id')->toArray();
        $clientId = $request->input('client_id', $pickList->client_id);

        // Handle AJAX request for DataTable
        if ($request->ajax()) {
            // If client_id is not passed, return empty
            if (!$request->filled('client_id')) {
                return datatables()->of(collect())->make(true);
            }

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
                    ->where('available_qty', '>', 0)
                    ->select('cs_stock.*');
            
             if ($request->has('only_picked') && $request->only_picked == 1) {
                // CASE 1 → First show picked items
                $query->whereIn('cs_stock.room_id', $pickList->pickListDetails->pluck('room_id')->toArray())
                    ->whereIn('cs_stock.rack_id', $pickList->pickListDetails->pluck('rack_id')->toArray())
                    ->whereIn('cs_stock.slot_id', $pickList->pickListDetails->pluck('slot_id')->toArray())
                    ->whereIn('cs_stock.pallet_id', $pickList->pickListDetails->pluck('pallet_id')->toArray())
                    ->whereIn('cs_stock.packing_list_detail_id', $pickedIds);
            } 

            $query->orderByRaw("(
                        SELECT COUNT(*) FROM cs_picklist_detail d 
                        WHERE 
                            d.room_id = cs_stock.room_id AND
                            d.rack_id = cs_stock.rack_id AND
                            d.slot_id = cs_stock.slot_id AND
                            d.pallet_id = cs_stock.pallet_id AND
                            d.packing_list_detail_id = cs_stock.packing_list_detail_id AND
                            d.picklist_id = ?
                    ) DESC", [$pickList->picklist_id]);
            
            // Handle individual column filters
            if ($request->has('columns')) {
                $cols = $request->get('columns');

                // if (!empty($cols[1]['search']['value'])) {
                //     $query->whereHas('room', fn($q) =>
                //         $q->where('name', 'like', '%' . $cols[1]['search']['value'] . '%')
                //     );
                // }

                // if (!empty($cols[2]['search']['value'])) {
                //     $query->whereHas('rack', fn($q) =>
                //         $q->where('name', 'like', '%' . $cols[2]['search']['value'] . '%')
                //     );
                // }

                // if (!empty($cols[3]['search']['value'])) {
                //     $query->whereHas('slot', fn($q) =>
                //         $q->where('name', 'like', '%' . $cols[3]['search']['value'] . '%')
                //     );
                // }

                if (!empty($cols[1]['search']['value'])) {
                    // $query->whereHas('room', fn($q) =>
                    //     $q->where('name', 'like', '%' . $cols[1]['search']['value'] . '%')
                    // );

                    $search = strtolower($cols[1]['search']['value']); // force input to lowercase
                    $parts = explode('-', $search);

                    $query->where(function ($q) use ($parts) {
                        foreach ($parts as $part) {
                            $matched = false;

                            // Match Level: L4, l4, L
                            if (preg_match('/^l(\d*)$/', $part, $m)) {
                                $matched = true;
                                $level = $m[1] ?? '';
                                $q->whereHas('slot', function ($qs) use ($level) {
                                    $qs->whereRaw('LOWER(level_no) like ?', ["%$level%"]);
                                });
                            }

                            // Match Depth: D1, d1, D
                            elseif (preg_match('/^d(\d*)$/', $part, $m)) {
                                $matched = true;
                                $depth = $m[1] ?? '';
                                $q->whereHas('slot', function ($qs) use ($depth) {
                                    $qs->whereRaw('LOWER(depth_no) like ?', ["%$depth%"]);
                                });
                            }

                            // Match Rack: R2, r2
                            elseif (str_starts_with($part, 'r')) {
                                $matched = true;
                                $q->whereHas('rack', function ($qr) use ($part) {
                                    $qr->whereRaw('LOWER(name) like ?', ["%$part%"]);
                                });
                            }

                            // Fallback to Room
                            if (!$matched) {
                                $q->whereHas('room', function ($qr) use ($part) {
                                    $qr->whereRaw('LOWER(name) like ?', ["%$part%"]);
                                });
                            }
                        }
                    });
                }

                if (!empty($cols[2]['search']['value'])) {
                    $query->whereHas('pallet', fn($q) =>
                        $q->where('name', 'like', '%' . $cols[4]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[3]['search']['value'])) {
                    $query->whereHas('product', fn($q) =>
                        $q->where('product_description', 'like', '%' . $cols[5]['search']['value'] . '%')
                    );
                }

                if (!empty($cols[4]['search']['value'])) {
                    $query->where('batch_no', 'like', '%' . $cols[6]['search']['value'] . '%');
                }
            }

            // Return filtered data
            return DataTables::eloquent($query)
                ->addColumn('pick', function ($row) use ($pickList) {
                    $detail = $pickList?->pickListDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->where('packing_list_detail_id', $row->packing_list_detail_id)
                        ->first();

                    $existing = $detail !== null;
                    $checked = ($existing) ? 'checked' : '';
                    
                    return '<input type="checkbox" class="pick-check" data-package-qty="' . $row->available_qty . '" name="picks[]" data-pallet-id="' . $row->pallet_id . '" data-packing-list-detail-id="' . $row->packing_list_detail_id . '" ' . $checked . '>';
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
                // ->addColumn('client_name', fn($row) =>
                //     $row->packingListDetail->packingList->client->client_name ?? '-'
                // )
                ->addColumn('pick_qty', function ($row) use ($pickList) {
                    $detail = $pickList?->pickListDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->where('packing_list_detail_id', $row->packing_list_detail_id)
                        ->first();

                    return $detail?->quantity ?? 0;
                })
                ->addColumn('picked', function ($row) use ($pickList) {
                    return $pickList->pickListDetails
                        ->where('room_id', $row->room_id)
                        ->where('rack_id', $row->rack_id)
                        ->where('slot_id', $row->slot_id)
                        ->where('pallet_id', $row->pallet_id)
                        ->where('packing_list_detail_id', $row->packing_list_detail_id)
                        ->isNotEmpty() ? 1 : 0;
                })
                ->rawColumns(['pick'])
                ->make(true);
        }

        return view('admin.inventory.pick-list.edit', compact('pickList', 'products', 'clients', 'brands', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Calculate total quantity from selected items
        $totalPickedQty = collect($request->selected_items)->sum('pick_qty');
        $palletQty = 0;

        // Check if total picked qty matches expected
        if ((float) $request->total_qty !== (float) $totalPickedQty) {
            return back()->withErrors(['selected_items' => 'Total picked quantity must match the total quantity to pick.'])->withInput();
        }

        $detailIds = collect($request->selected_items)->pluck('packing_list_detail_id');
        $palletIds = collect($request->selected_items)->pluck('pallet_id');

        $packingListIds = PackingListDetail::whereIn('packing_list_detail_id', $detailIds)
            ->pluck('packing_list_id')
            ->unique();

        DB::beginTransaction();

        try {
            // Update the PickList main fields
            $pickList = PickList::findOrFail($id);

            $pickList->fill([
                'doc_date'           => $request->doc_date,
                'dispatch_date'      => $request->dispatch_date,
                'dispatch_location'  => $request->dispatch_location,
                'client_id'          => $request->client_id,
                'contact_name'       => $request->contact_name,
                'contact_address'    => $request->contact_address,
                'tot_package_qty'   => $totalPickedQty,
            ]);

            $pickList->save();

            // Existing picked items in DB
            $existingPickListDetails = PickListDetail::where('picklist_id', $pickList->picklist_id)->get();

            // 1️⃣ Delete removed items (unchecked now)
            $existingToDelete = $existingPickListDetails
                // ->whereNotIn('packing_list_detail_id', $detailIds)
                ->whereNotIn('pallet_id', $palletIds);

            // foreach ($existingToDelete as $toDelete) {
            //     // $toDelete->delete();
            //     // $pickList = $toDelete->pickList;
            //     $toDelete->status = 'cancelled';
            //     $toDelete->save();
                
            //     if ($toDelete->pallet) {
            //         $toDelete->pallet->update([
            //             'movement_type' => MovementType::In
            //         ]);
            //     }
            // }
            
            // 2️⃣ Add / update submitted items
            foreach ($request->selected_items as $item) {
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
                    'pallet_id' => $item['pallet_id']
                ],
                    [
                    'quantity' => $item['pick_qty'],
                    'picklist_id' => $pickList->picklist_id
                ]);

                $palletQty++;
            }

            $pickList->pallet_qty = $palletQty;
            $pickList->save();

            DB::commit();

            return redirect()
                ->route('admin.inventory.pick-list.index')
                ->with('success', 'Pick List updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function submit(Request $request)
    {
       
    }

    public function print($id)
    {
        $pickList = PickList::with(['client', 'pickListDetails.packingListDetail.packageType', 'pickListDetails.room', 'pickListDetails.rack', 'pickListDetails.slot', 'pickListDetails.pallet'])->findOrFail($id);
        $pickListDetails = $pickList->pickListDetails;

        return view('admin.inventory.pick-list.print', compact('pickList', 'pickListDetails'));
    }

    // public function changeStatus(Request $request)
    // {
    //     $picklist_id = $request->input('picklist_id');
    //     $status = $request->input('status');

    //     $pickList = PickList::findOrFail($picklist_id);
    //     $pickList->status = $status;
    //     $pickList->save();

    //     $pickList->updateStatus();
        
    //     echo true;
    // }

    public function changeStatus(Request $request, InventoryStatusTransitionService $service)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $newStatus = $request->input('status');
        $picklist_id = $request->input('picklist_id');

        $pickList = PickList::with(['details', 'pickListDetails'])->findOrFail($picklist_id);

        // Validate all detail transitions
        foreach ($pickList->pickListDetails as $detail) {
            if (!$service->isAllowed('picklist', $detail->status, $newStatus)) {
                return response()->json([
                    'message' => "Invalid transition from {$detail->status} to {$newStatus} on detail ID {$detail->picklist_detail_id}"
                ], 422);
            }
        }

        // Apply transition
        $service->apply($pickList, $newStatus);

        // return response()->json(['message' => 'Status updated successfully', 'status' => $pickList->status]);

        echo true;
    }
}

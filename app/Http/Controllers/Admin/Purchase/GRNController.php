<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;

use App\Models\Purchase\GRN;
use App\Models\Purchase\GRNDetail;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Slot;
use App\Models\Master\Inventory\Pallet;
use App\Models\Master\Inventory\PalletType;
use App\Models\Master\Inventory\ProductAttribute;
use App\Models\Tray;
use App\Models\Master\Inventory\Product;
use App\Models\Master\Inventory\ProductMaster;
use App\Models\Client;
use App\Models\Master\Purchase\Supplier;
use App\Models\Inventory\Stock;
use App\Models\Inventory\Inward;
use App\Models\Inventory\InwardDetail;
use App\Models\Inventory\PackingList;

use App\Services\Inventory\InwardService;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;

use DataTables;

class GRNController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = GRN::with(['supplier.supplierCategory'])
                    ->select(['GRNBatchID', 'Prefix', 'Suffix', 'GRNDate','SupplierID', 'LocationID', 'InvoiceNumber', 'Amount', 'Status', DB::raw('CONCAT(Prefix, Suffix) AS GRNNo')])
                    ->where('Status','finalized');
        $data = GRN::with(['supplier.supplierCategory'])
                    ->select(['GRNBatchID', 'Prefix', 'Suffix', 'GRNDate','SupplierID', 'LocationID', 'InvoiceNumber', 'Amount', 'Status', DB::raw('CONCAT(Prefix, Suffix) AS GRNNo')])
                    ->where('Status','finalized');

        // If filtering by SupplierCategory
        $data->whereHas('supplier.supplierCategory', function($query) {
            $query->where('supplier_category_id', 7);
        });

        // If date filter applied
        if ($request->from_date && $request->to_date) {
            $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
            $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

            $data->whereBetween('GRNDate', [$from_date, $to_date]);
        }

        // If quick search applied
        if ($request->get('quick_search')) {
            $search = $request->get('quick_search');

            $data->where(function($w) use($search){
                $w->whereHas('supplier', function($q) use($search){
                    $q->where('supplier_name', 'LIKE', "%$search%");
                });
                $w->orWhere(DB::raw('CONCAT(Prefix, Suffix)'), 'LIKE', "%$search%"); 
                $w->orWhere('InvoiceNumber', 'LIKE', "%$search%"); 
            });
        }

         // Handle individual column filters
        if ($request->has('columns')) {
            $cols = $request->get('columns');

            if (!empty($cols[1]['search']['value'])) {
                $data->where(DB::raw('CONCAT(Prefix, Suffix)'), 'like', '%' . $cols[1]['search']['value'] . '%');
            }

            if (!empty($cols[2]['search']['value'])) {
                $data->whereHas('supplier', fn($q) =>
                    $q->where('supplier_name', 'like', '%' . $cols[2]['search']['value'] . '%')
                );
            }

            if (!empty($cols[3]['search']['value'])) {
                $data->where('InvoiceNumber', 'like', '%' . $cols[3]['search']['value'] . '%');
            }

            if (!empty($cols[4]['search']['value'])) {
                $data->where('Amount', 'like', '%' . $cols[4]['search']['value'] . '%');
            }
        }

        // Now run the query!
        $data = $data->get();

        // Now filter on Collection for appended attribute
        if ($request->status !== null && $request->status !== '') {
            $data = $data->filter(function ($item) use ($request) {
                return $item->IsFullyAssigned == $request->status;
            });
        }

        if ($request->ajax()) {
            // Now pass to DataTables
            return DataTables::of($data)
                ->editColumn('GRNDate', function ($res) {
                    return date('d/m/Y', strtotime($res->GRNDate));
                })
                ->editColumn('Amount', function ($res) {
                    return number_format($res->Amount, 2, '.', ',');
                })
                ->addColumn('assigned_progress', function($res) {
                    $percentage = $res->assigned_percentage;

                    $progressColor = 'bg-success';
                    if ($percentage < 100 && $percentage > 0) {
                        $progressColor = 'bg-warning';
                    } elseif ($percentage == 0) {
                        $progressColor = 'bg-danger';
                    }

                    return '
                    <div class="progress-percentage">' . $percentage . '%</div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar ' . $progressColor . '" role="progressbar" 
                            style="width: ' . $percentage . '%; transition: width 0.6s ease;" 
                            aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    ';
                })
                ->addColumn('status', function($res) {
                    if ($res->is_fully_assigned) {
                        return '<span class="badge bg-success">Fully Assigned</span>';
                    } else {
                        return '<span class="badge bg-warning">Not Assigned</span>';
                    }
                })
                ->editColumn('GRNDate', function($res) {
                    return $res->GRNDate; //$res->formatDate('GRNDate');
                })
                ->addColumn('actions', function($res) {
                    return '<a href="'.route('admin.purchase.grn.view', $res->GRNBatchID).'" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>';
                })
                ->rawColumns(['actions', 'status', 'assigned_progress'])
                ->addIndexColumn()
                ->make(true);
        }
        $defaultDate = Carbon::now()->format('Y-m-d');

        return view('admin.purchase.grn.index', compact('defaultDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.purchase.grn.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $availablePallets = Pallet::with('stock') 
        //                         ->get()
        //                         ->map(function ($pallet) {
        //                             return [
        //                                 'pallet_id' => $pallet->pallet_id,
        //                                 'current' => $pallet->current_pallet_capacity ?? 0
        //                             ];
        //                         });
                                
        // $grn = GRN::with('productmasters')->findOrFail($id);
        return view('admin.purchase.grn.view');
    }

    public function assign(string $grnBatchID, string $id)
    {
        $availableSlots = Slot::with(['stock', 'palletType']) 
            ->whereIn('status', ['partial', 'empty'])
            ->get()
            ->map(function ($slot) {
                return [
                    'status' => $slot->status,
                    'slot_id' => $slot->slot_id,
                    'pallet_type' => $slot->palletType? $slot->palletType->type_name : 'half',
                    'total' => $slot->pallet->pallet_capacity ?? 0,
                    'current' => $slot->pallet->current_pallet_capacity ?? 0,
                    // 'products' => $pallet->available_products->map(function ($stock) {
                    //     return [
                    //         'name' => $stock->product->product_description,
                    //         'svg_icon' => $stock->product->CatSvgIcon->svg_icon ?? '',
                    //     ];
                    // }),
                ];
            });
                       
        $grn = GRN::with('productmasters')->findOrFail($grnBatchID);
        $rooms = StorageRoom::with(['racks.pallets', 'racks'])->get();
        $grnDetail = GRNDetail::with(['stock','productMaster','inward'])->findOrFail($id);
        $clients = Client::all();
        $palletTypes = PalletType::active()->get();
        $defaultDate = Carbon::now()->format('Y-m-d');
        $attributes = ProductAttribute::get();

        return view('admin.purchase.grn.assign', compact('grn', 'rooms', 'grnBatchID', 'grnDetail', 'availableSlots', 'clients', 'defaultDate', 'attributes', 'palletTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.purchase.grn.form');
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

    public function assignProductToStorage(Request $request, InwardService $service)
    {
        $validated = $request->validate([
            'product_master_id'      => 'required|integer',
            'grn_detail_id'          => 'required|integer',
            'package_qty_per_half_pallet'=> 'required',
            'package_qty_per_full_pallet'=> 'required',
            'assignments'            => 'required|array|min:1',
        ]);

        $result = $service->assignProduct($request->all(), auth()->user());

        return response()->json([
            'message' => $result['message'],
            'error' => $result['error'] ?? null,
        ], $result['status'] ? 200 : 500);
    }

      // Fetch available storage rooms with status
    public function getStorageRooms()
    {
        $storageRooms = StorageRoom::with('racks')->get();

        return response()->json([
            'rooms' => $storageRooms->map(function ($room) {
                return [
                    'id' => $room->room_id,
                    'name' => $room->name,
                    'status' => $room->is_active ? 'available' : 'full',
                ];
            }),
        ]);
    }

    // Fetch available racks in a selected storage room
    public function getRacks(Request $request)
    {
        $racks = Rack::with([
                'room',
                'slots' => function ($query) {
                    $query->with(['pallet']); // Only load pallet, not rack/room again
                },
                'slots.palletType',
                'slots.pallet.products'
            ])
            ->whereHas('room', function ($query) use ($request) {
                $query->where('room_id', $request->room_id);
            })
            ->select('room_id', 'rack_no', 'rack_id', 'no_of_levels', 'no_of_depth', 'name')
            ->get();


        // $racks = Rack::with(['slots.pallet','slots.room', 'slots.rack', 'room'])
        //             ->whereHas('room', function ($query) use ($request) {
        //                 $query->where('room_id', $request->room_id);
        //             })
        //             // ->whereHas('slots.pallet', function ($query) {
        //             //     $query->whereIn('status', ['partial', 'empty']);
        //             // })
        //             ->get()
                    // ->map(function ($rack) use ($request) {
                    //     $inputCapacity = $request->box_capacity ?? 40;
                
                    //     // $rack->slots = $rack->slots->filter(function ($slot) use ($inputCapacity) {
                    //     //     $totalQty = $slot->pallet? $slot->pallet->stock->sum('quantity') : 0;
                    //     //     $outQty = $slot->pallet? $slot->pallet->stock->where('movement_type', 'out')->sum('quantity') : 0;
                
                    //     //     $current = $totalQty - $outQty;
                
                    //     //     return $current <= $inputCapacity;
                    //     // });
                    //     $rack->slots = $rack->slots->filter(function ($slot) use ($inputCapacity) {
                    //         if ($inputCapacity) {
                    //             $totalQty = $slot->pallet ? $slot->pallet->stock->sum('quantity') : 0;
                    //             $outQty = $slot->pallet ? $slot->pallet->stock->where('movement_type', 'out')->sum('quantity') : 0;

                    //             $currentQty = $totalQty - $outQty;

                    //             return $currentQty <= $inputCapacity;
                    //         } else {
                    //             return $slot->status == 'empty';
                    //         }
                    //     });
                
                    //     return $rack;
                    // });

        // $racks = Rack::with(['pallets' => function ($query) use ($request) {
        //                 $inputCapacity = $request->box_capacity ?? 40;

        //                 $query->get()->filter(function ($pallet) use ($inputCapacity) {
        //                     $current = $pallet->stock
        //                                     ->where('movement_type', 'in')->whereIn('status',['partial','empty'])->sum('quantity')
        //                                 - $pallet->stock
        //                                     ->where('movement_type', 'out')->whereIn('status',['partial','empty'])->sum('quantity');

        //                     return $current <= $inputCapacity;
        //                 });
        //             }])
        //             ->whereHas('room', function ($query) use ($request) {
        //                 $query->where('room_id', $request->room_id);
        //             })->get();

        return response()->json(['racks' => $racks]);
    }
    
    // public function getRacks(Request $request)
    // {
    //     $inputCapacity = $request->box_capacity ?? 40;
    
    //     $racks = Rack::whereHas('room', function ($query) use ($request) {
    //             $query->where('room_id', $request->room_id);
    //         })
    //         ->with([
    //             'room',
    //             'slots' => function ($query) use ($inputCapacity) {
    //                 $query->whereHas('pallet', function ($q) use ($inputCapacity) {
    //                     $q->withSum('inventory as total_in', 'quantity')
    //                       ->withSum('outInventory as total_out', 'quantity')
    //                       ->havingRaw('(COALESCE(total_in, 0) - COALESCE(total_out, 0)) <= ?', [$inputCapacity]);
    //                 });
                    
    //                 $query->whereHas('pallet', function ($q) {
    //                     $q->orWhereNull('pallet_id');
    //                 });
    //                 // Allow empty slots too
    //             },
    //             'slots.pallet',
    //             'slots.room',
    //             'slots.rack',
    //         ])
    //         ->withCount('slots') // Optional: if you want to know how many slots each rack has
    //         ->get()
    //         ->filter(function ($rack) {
    //             return $rack->slots->isNotEmpty();
    //         })
    //         ->values(); // Reindex
    
    //     return response()->json(['racks' => $racks]);
    // }

    public function syncFromPJJERP(Request $request)
    {
        $validated = $request->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date',
        ]);

        $apiKey = '$2a$12$mln1qU';
        $url = 'https://pjjerp.com/api/coldstorage/grn/';
        // $url = 'http://localhost/pjj.erp.local/api/coldstorage/grn/';
        $url .= $apiKey . '/' . $validated['fromDate'] . '/' . $validated['toDate'] . '/';

       // try {
            $response = Http::get($url);

            if ($response->successful() && $response->json('status') === 'success') {
                $data = $response->json('data');

                // echo '<pre>'; print_r($data);

                DB::beginTransaction();

                // Suppliers
                foreach ($data['Suppliers'] as $d) {
                    // Check if already exists
                    $exists = Supplier::where('supplier_id', $d['supplier_id'])->exists();
                    if ($exists) {
                        continue; // Skip if exists
                    }

                    // Insert Suppliers
                    Supplier::create($d);
                }
                
                // Product Masters
                foreach ($data['ProductMasters'] as $d) {
                    // Check if already exists
                    $exists = ProductMaster::where('product_master_id', $d['ProductMasterID'])->exists();
                    if ($exists) {
                        continue; // Skip if exists
                    }

                    // Insert Suppliers
                    ProductMaster::create($d);
                }

                // Product
                foreach ($data['Products'] as $d) {
                    // Check if already exists
                    $exists = Product::where('product_id', $d['product_id'])->exists();
                    if ($exists) {
                        continue; // Skip if exists
                    }

                    // Insert Suppliers
                    Product::create($d);
                }
                
                // GRN
                foreach ($data['GRN'] as $d) {
                    $products = $d['Products'] ?? [];
                    unset($d['Products']);

                    // Check if GRN already exists
                    $exists = GRN::where('GRNBatchID', $d['GRNBatchID'])->exists();
                    if ($exists) {
                        continue; // Skip if exists
                    }

                    // Insert GRN
                    GRN::create($d);

                    // Insert GRNDetail
                    foreach ($products as $product) {
                        GRNDetail::create($product);
                    }
                }

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data synced successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch data from ERP',
                    'details' => $response->body(),
                ], $response->status());
            }
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Exception occurred while syncing ERP data',
        //         'details' => $e->getMessage(),
        //     ], 500);
        // }
    }

    public function print(string $id)
    {
        return view('admin.purchase.grn.print');
    }
}

<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Inventory\PackingList;
use App\Models\Inventory\PackingListDetail;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Pallet;
use App\Models\Master\Inventory\ProductMaster;
use App\Models\Client;
use App\Models\Master\Purchase\Supplier;
use App\Models\Master\General\Unit;
use App\Models\Master\Inventory\ProductCategory;
use App\Models\Master\General\Brand;
use App\Models\Master\General\Port;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DataTables;

class PackingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $data = PackingList::with(['client'])->select(['packing_list_id', 'doc_no', 'doc_date', 'invoice_no', 'invoice_date','status','client_id'])
                            ->orderBy('created_at', 'desc');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') != '') {
                        $instance->where('status', $request->get('status'));
                    }

                    if ($request->get('client_flt') != '') {
                        $instance->whereHas('client', function ($q) use ($request) {
                            $q->where('client_name', 'like', "%{$request->get('client_flt')}%");
                        });
                    }

                    if ($request->from_date && $request->to_date) {
                        $instance->whereHas('grn', function ($q) use ($request) {
                            $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                            $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

                            $q->whereBetween('GRNDate', [
                                    $from_date,
                                    $to_date
                                ]);
                        });
                    }

                    if ($request->get('quick_search')) {
                        $search = $request->get('quick_search');

                        $instance->where(function($w) use($search){
                            $w->whereHas('supplier', function($q) use($search){
                                $q->where('supplier_name', 'LIKE', "%$search%");
                            });
                            $w->orWhere(DB::raw('CONCAT(Prefix, Suffix)'), 'LIKE', "%$search%"); 
                            $w->orWhere('InvoiceNumber', 'LIKE', "%$search%"); 
                        });
                    }
                })
                ->editColumn('doc_date', function ($res) {
                    return date('j F, Y', strtotime($res->doc_date));
                })
                ->addColumn('actions', function($res) {
                    $editBtn = '<a href="'.route('admin.inventory.packing-list.edit', $res->packing_list_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';

                    $viewBtn = '<a href="'.route('admin.inventory.packing-list.view', $res->packing_list_id).'" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>';
                    return $editBtn . ' ' . $viewBtn;
                })
                ->rawColumns(['actions', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.inventory.packing-list.index', compact('clients'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $packingList = PackingList::with('packingListDetails.packageType')->findOrFail($id);
        $packingListDetail = PackingListDetail::where('packing_list_id', $id)->get();
        
        return view('admin.inventory.packing-list.view', compact('packingList', 'packingListDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $suppliers = Supplier::all();
        $clients = Client::all();
        $packageTypes = Unit::all();
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $ports = Port::all();
        $packingList = PackingList::with('packingListDetails.packageType')->findOrFail($id);
        $packingListDetail = PackingListDetail::where('packing_list_id', $id)->get();
        
        return view('admin.inventory.packing-list.edit', compact('packingList', 'packingListDetail', 'suppliers', 'clients', 'packageTypes', 'categories', 'brands', 'ports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $packingList = PackingList::findOrFail($id);

            $packingList->fill([
                'client_id'         => $request->client_id,
                'doc_date'          => $request->doc_date,
                'invoice_no'        => $request->invoice_no,
                'invoice_date'      => $request->invoice_date,
                'supplier_id'       => $request->supplier_id,
                'contact_person'      => $request->contact_name,
                'contact_address'   => $request->contact_address,
                'no_of_containers'  => $request->no_of_containers,
                'package_type_id'   => $request->package_type_id,
                'loading_date'      => $request->loading_date,
                'loading_port_id'   => $request->loading_port_id,
                'discharge_port_id' => $request->discharge_port_id,
                'vessel_name'       => $request->vessel_name,
                'voyage_no'         => $request->voyage_no,
                'updated_by'        => auth()->id(),
            ]);

            $packingList->save();

            if ($request->has('packing_list_detail_ids')) {
                foreach ($request->packing_list_detail_ids as $i => $detailId) {
                    $packingListDtl = PackingListDetail::findOrFail($detailId);

                    $packingListDtl->fill([
                        'product_id'              => $request->product_ids[$i],
                        'cargo_description'       => $request->cargo_description[$i],
                        'lot_no'                  => $request->lot_no[$i],
                        'variety_id'              => $request->variety_id[$i],
                        'brand_id'                => $request->brand_id[$i],
                        'class'                   => $request->class[$i],
                        'package_type_id'         => $request->package_type_ids[$i],
                        'package_qty'             => $request->package_qty[$i],
                        'item_size_per_package'   => $request->item_size_per_package[$i],
                        'package_qty_per_pallet'  => $request->package_qty[$i], 
                        'pallet_qty'              => $request->pallet_qty[$i],
                        'gw_per_package'          => $request->gw_per_package[$i],
                        'nw_per_package'          => $request->nw_per_package[$i],
                    ]);

                    $packingListDtl->save();
                }
            }

            DB::commit();

            return redirect()->route('admin.inventory.packing-list.index')->with('success', 'Packing List updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error'   => 'Failed to update Packing List',
                'details' => $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print($id)
    {
        $packingList = PackingList::with(['packingListDetails.packageType'])->findOrFail($id);
        $packingListDetails = $packingList->packingListDetails;

        return view('admin.inventory.packing-list.print', compact('packingList', 'packingListDetails'));
    }

    public function getPackingListDetails(Request $request)
    {
        $packingList = PackingList::with(['packingListDetails.product', 'grn', 'supplier'])
            ->where('packing_list_id', $request->packing_list_id)
            ->first();

        if (!$packingList) {
            return response()->json(['error' => 'Packing List not found'], 404);
        }

        return response()->json([
            'packingList' => [
                'client_id' => $packingList->client_id,
                'grn_no' => optional($packingList->grn)->GRNNo,
                'supplier_name' => optional($packingList->supplier)->supplier_name,
                'goods' => $packingList->goods,
                'size' => $packingList->size,
                'package_types' => $packingList->package_types,
                'loading_date' => $packingList->loading_date,
                'weight_per_pallet' => $packingList->weight_per_pallet,
                'total_pallet_qty' => $packingList->tot_pallet_qty,
                'tot_package' => $packingList->tot_package,
            ]
        ]);
    }

}

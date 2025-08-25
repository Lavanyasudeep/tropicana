<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Inventory\Stock;
use App\Models\Inventory\PickListDetail;
use App\Models\Inventory\OutwardDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inwardProducts = Stock::join('ProductMaster', 'cs_stock.product_id', '=', 'ProductMaster.product_master_id')
                                ->select(
                                    'cs_stock.product_id',
                                    'cs_stock.batch_no',
                                    'ProductMaster.product_description as product_name',
                                    DB::raw('SUM(cs_stock.available_qty) as total_qty')
                                )
                                ->where('cs_stock.available_qty', '>', 0)
                                ->groupBy('cs_stock.product_id', 'cs_stock.batch_no', 'ProductMaster.product_description')
                                ->get();
        
        $pickedItems = PickListDetail::join('cs_packing_list_detail', 'cs_picklist_detail.packing_list_detail_id', '=', 'cs_packing_list_detail.packing_list_detail_id')
                                ->join('ProductMaster', 'cs_packing_list_detail.product_id', '=', 'ProductMaster.product_master_id')
                                ->leftJoin('cs_outward_detail', 'cs_outward_detail.picklist_detail_id', '=', 'cs_picklist_detail.picklist_detail_id')
                                ->select(
                                    'cs_packing_list_detail.product_id',
                                    'cs_packing_list_detail.lot_no',
                                    'ProductMaster.product_description as product_name',
                                    DB::raw('SUM(cs_picklist_detail.quantity - IFNULL(cs_outward_detail.quantity, 0)) as total_qty')
                                )
                                ->groupBy('cs_packing_list_detail.product_id', 'cs_packing_list_detail.lot_no', 'ProductMaster.product_description')
                                ->having('total_qty', '>', 0)
                                ->get();

        $outwardItems = OutwardDetail::join('cs_picklist_detail', 'cs_outward_detail.picklist_detail_id', '=', 'cs_picklist_detail.picklist_detail_id')
                                ->join('cs_packing_list_detail', 'cs_picklist_detail.packing_list_detail_id', '=', 'cs_packing_list_detail.packing_list_detail_id')
                                ->join('ProductMaster', 'cs_packing_list_detail.product_id', '=', 'ProductMaster.product_id')
                                ->select(
                                    'cs_packing_list_detail.product_id',
                                    'cs_packing_list_detail.lot_no',
                                    'ProductMaster.product_description as product_name',
                                    DB::raw('SUM(cs_outward_detail.quantity) as total_qty')
                                )
                                ->groupBy('cs_packing_list_detail.product_id', 'cs_packing_list_detail.lot_no', 'ProductMaster.product_description')
                                ->get();
    
        return view('admin.product-flow.index', [
                        'inwardProducts' => $inwardProducts,
                        'pickedProducts' => $pickedItems,
                        'outwardProducts' => $outwardItems,
                    ]);
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
}

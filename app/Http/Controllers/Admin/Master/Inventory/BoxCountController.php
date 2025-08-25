<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DataTables;

use App\Models\Master\Inventory\ProductCategory;
use App\Models\Master\Inventory\ProductMaster;

class BoxCountController extends Controller
{
    public function index(Request $request)
    {
        $boxCounts = ProductMaster::with(['product', 'CatSvgIcon', 'purchaseunit'])->get();
        $data = ProductMaster::with(['product', 'CatSvgIcon', 'purchaseunit'])->select(['cs_product_master.*']);

        if ($request->ajax()) {
            return DataTables::of($data)
            ->addColumn('svg_icon', function($row) {
                $icon = optional($row->CatSvgIcon)->svg_icon ?? 'default.svg';
                return $icon;
            })
            ->addColumn('weight_per_box', function($row) {
                return '<input type="number" name="box_weight['.$row->product_master_id.']" value="'.$row->weight_per_box.'" class="form-control" min="0.00">';
            })
            ->addColumn('box_capacity_per_full_pallet', function($row) {
                return '<input type="number" name="box_capacity_per_full_pallet['.$row->product_master_id.']" value="'.$row->box_capacity_per_full_pallet.'" class="form-control" min="0">';
            })
            ->addColumn('box_capacity_per_half_pallet', function($row) {
                return '<input type="number" name="box_capacity_per_half_pallet['.$row->product_master_id.']" value="'.$row->box_capacity_per_half_pallet.'" class="form-control" min="0">';
            })
            ->rawColumns(['svg_icon', 'weight_per_box', 'box_capacity_per_full_pallet', 'box_capacity_per_half_pallet'])
            ->make(true);
        }
        return view('admin.master.inventory.box-count.index', compact('boxCounts'));
    }

    public function update(Request $request)
    {
        // Retrieve all input data
        $input = $request->all();

        // Iterate over the box_counts array
        foreach ($input['box_capacity_per_full_pallet'] as $id => $count) {
            $weight = $input['box_weight'][$id] ?? null;

            // Update the ProductMaster record
            ProductMaster::where('product_master_id', $id)
                        ->update([
                            'box_capacity_per_full_pallet' => $count,
                            'box_capacity_per_half_pallet' => $input['box_capacity_per_half_pallet'][$id],
                            'weight_per_box' => $weight
                        ]);
        }

        return redirect()->route('admin.master.inventory.box-count.index')->with('success', 'Box counts updated successfully.');
    }
}

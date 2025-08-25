<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Models\Master\General\{ ProductType, ProductTypePrice, Unit};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

class ProductTypePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prices = ProductTypePrice::with(['productType', 'unit'])->get();

        if ($request->ajax()) {
            return DataTables::of($prices)
                ->addColumn('product_type', fn ($row) => $row->productType->type_name ?? '')
                ->addColumn('unit', fn ($row) => $row->unit->unit ?? '')
                ->addColumn('is_active', fn ($row) =>
                    '<button class="btn btn-sm toggle-status ' . ($row->is_active ? 'btn-success' : 'btn-secondary') . '" data-id="' . $row->product_type_price_id . '">' . ($row->is_active ? 'Active' : 'Inactive') . '</button>'
                )
                ->addColumn('actions', function ($row) {
                    return '
                        <button class="btn btn-warning btn-sm edit-btn"
                            data-id="' . $row->price_id . '"
                            data-product-type-id="' . $row->product_type_id . '"
                            data-unit-id="' . $row->unit_id . '"
                            data-price="' . $row->price . '">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="' . route('admin.master.general.product-type-price.destroy', $row->price_id) . '" onsubmit="return confirm(\'Are you sure?\')" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['is_active', 'actions'])
                ->make(true);
        }

        $productTypes = ProductType::where('active', 1)->get();
        $units = Unit::where('active', 1)->get();

        return view('admin.master.general.product-type-price.index', compact('productTypes', 'units'));
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
        $request->validate([
            'product_type_id' => 'required',
            'unit_id' => 'required',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:weekly,monthly',
        ]);

        ProductTypePrice::create([
            'company_id' => auth()->user()->company_id,
            'branch_id' => auth()->user()->branch_id,
            'product_type_id' => $request->product_type_id,
            'unit_id' => $request->unit_id,
            'price' => $request->price
        ]);

        return back()->with('success', 'Price added.');
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
    public function update(Request $request, $id)
    {
        $price = ProductTypePrice::findOrFail($id);
        $request->validate([
            'product_type_id' => 'required',
            'unit_id' => 'required',
            'price' => 'required|numeric|min:0'
        ]);

        $price->update([
            'product_type_id' => $request->product_type_id,
            'unit_id' => $request->unit_id,
            'price' => $request->price
        ]);

        return back()->with('success', 'Price updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        ProductTypePrice::findOrFail($id)->delete();
        return back()->with('success', 'Deleted.');
    }

    public function toggleStatus(Request $request)
    {
        $price = ProductTypePrice::findOrFail($request->id);
        $price->active = !$price->active;
        $price->save();

        return response()->json(['success' => true, 'status' => $price->active]);
    }
}

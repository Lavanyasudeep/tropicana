<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Models\Master\Inventory\ProductAttribute;

use App\Http\Requests\Master\Inventory\ProductAttributeRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductAttribute::query();
            return DataTables::of($query)
                ->addColumn('actions', function ($row) {
                    $editUrl = route('admin.master.inventory.product-attributes.edit', $row->product_attribute_id);
                    $deleteUrl = route('admin.master.inventory.product-attributes.destroy', $row->product_attribute_id);

                    return '
                        <a href="javascript:void(0);" onclick="editAttribute(' . $row->product_attribute_id . ')" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.master.inventory.product-attributes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeRequest $request)
    {
        DB::beginTransaction();

        try {
            $attribute = ProductAttribute::create($request->validated());

            DB::commit();

            if($request->ajax()) {
                return response()->json([
                    'message' => 'Attribute created successfully',
                    'data' => $attribute,
                ]);
            } else {
                return redirect()->back()->with('success', 'Attribute created successfully.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to create attribute',
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
        $attribute = ProductAttribute::findOrFail($id);
        return response()->json($attribute);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $attribute = ProductAttribute::findOrFail($id);
            $attribute->update($request->validated());

            DB::commit();

            return redirect()->back()->with('success', 'Attribute updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to create attribute',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->delete();

        return redirect()->back()->with('success', 'Attribute deleted successfully.');
    }

    public function inputField($id, Request $request)
    {
        $attribute = ProductAttribute::findOrFail($id);

        // Generate the input field based on data type
        $inputHtml = match ($attribute->data_type) {
            'text' => "<input type=\"text\" name=\"products[{$request->product_index}][specifications][{$request->row_index}][value]\" class=\"form-control form-control-sm spec-value-input\" required>",
            'number' => "<input type=\"number\" name=\"products[{$request->product_index}][specifications][{$request->row_index}][value]\" class=\"form-control form-control-sm spec-value-input\" required>",
            'color' => "<input type=\"color\" name=\"products[{$request->product_index}][specifications][{$request->row_index}][value]\" class=\"form-control form-control-sm spec-value-input\" required>",
            'boolean' => "<select class=\"form-control form-control-sm spec-value-input\" name=\"products[{$request->product_index}][specifications][{$request->row_index}][value]\" required>
                            <option value=\"1\">Yes</option>
                            <option value=\"0\">No</option>
                        </select>",
            'date' => "<input type=\"date\" class=\"form-control form-control-sm spec-value-input\" name=\"products[{$request->product_index}][specifications][{$request->row_index}][value]\" required>",
            default => "<input type=\"text\" class=\"form-control form-control-sm spec-value-input\" name=\"products[{$request->product_index}][specifications][{$request->row_index}][value]\" required>",
        };

        return response()->json(['input' => $inputHtml]);
    }

}

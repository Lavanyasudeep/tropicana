<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Http\Requests\Master\General\TaxRequest;
use App\Models\Master\General\Tax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $taxes = Tax::get();

        if ($request->ajax()) {
            return DataTables::of($taxes)
                ->editColumn('is_active', function ($tax) {
                    return '<button class="btn btn-sm toggle-status ' . ($tax->is_active ? 'btn-success' : 'btn-secondary') . '" data-id="' . $tax->tax_id . '">' . ($tax->is_active ? 'Active' : 'Inactive') . '</button>';
                })
                ->addColumn('actions', function ($tax) {
                    return '
                        <button class="btn btn-sm btn-warning edit-btn" 
                                data-id="' . $tax->tax_id . '" 
                                data-tax-per="' . $tax->tax_per . '" 
                                data-input="' . $tax->gst_input_account_code . '" 
                                data-output="' . $tax->gst_output_account_code . '" 
                                title="Edit"
                        ><i class="fas fa-edit"></i></button>
                        <form method="POST" action="' . route('admin.master.general.tax.destroy', $tax->tax_id) . '" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['is_active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.general.tax.index');
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
    public function store(TaxRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = auth()->user()->company_id;

        Tax::create($data);
        return redirect()->back()->with('success', 'Tax created successfully.');
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
    public function update(TaxRequest $request, $id)
    {
        $tax = Tax::findOrFail($id);
        $data = $request->validated();
        $tax->update($data);

        return redirect()->back()->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        return redirect()->back()->with('success', 'Tax deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $tax = Tax::findOrFail($request->id);
        $tax->active = !$tax->active;
        $tax->save();

        return response()->json(['success' => true, 'status' => $tax->active]);
    }
}

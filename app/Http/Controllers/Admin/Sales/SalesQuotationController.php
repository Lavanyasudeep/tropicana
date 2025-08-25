<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Models\Client;
use App\Models\Master\General\{ Unit, ProductType, Tax};
use App\Models\Master\Sales\{ Customer, SalesItem };
use App\Models\Sales\{ SalesQuotation};
use App\Models\Master\General\Status;

use App\Http\Requests\Sales\SalesQuotationRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;
use Carbon\Carbon;

class SalesQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = Customer::all();
        $statuses = Status::select('status_name')->where('doc_type', 'sales_quotation')->get();

        if ($request->ajax()) {
            $query = SalesQuotation::with(['customer', 'quotationDetails.product'])
                ->orderBy('created_at', 'desc');

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if (!empty($search)) {
                        $query->where(function ($q) use ($search) {
                            $q->where('quotation_no', 'like', "%{$search}%")
                                ->orWhereHas('customer', function ($q2) use ($search) {
                                    $q2->where('customer_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('quotationDetails.product', function ($q2) use ($search) {
                                    $q2->where('product_description', 'like', "%{$search}%");
                                });
                        });
                    }

                    if ($request->from_date && $request->to_date) {
                        $from = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                        $to = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                        $query->whereBetween('created_at', [$from, $to]);
                    }

                    if ($request->filled('customer_flt')) {
                        $query->where('customer_id', $request->customer_flt);
                    }

                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }
                })
                ->editColumn('doc_date', function ($quotation) {
                    return $quotation->doc_date ? Carbon::parse($quotation->doc_date)->format('d-m-Y') : '-';
                })
                ->addColumn('no_of_items', function ($quotation) {
                    return $quotation->quotationDetails->count();
                })
                ->addColumn('status', function ($quotation) {
                    return ucfirst($quotation->status);
                })
                ->addColumn('action', function ($quotation) {
                    $act = '';
                    if ($quotation->status === 'created') {
                        $act .= '<a href="' . route('admin.sales.sales-quotation.edit', $quotation->sq_id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                    $act .= '<a href="' . route('admin.sales.sales-quotation.print', $quotation->sq_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.sales.sales-quotation.view', $quotation->sq_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    return $act;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.sales.sales-quotation.index', compact('customers', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::select('customer_id', 'customer_name', 'phone_number')->get();
        $salesItems = SalesItem::select('sales_item_id', 'sales_item_name')->get();
        $productTypes = ProductType::select('product_type_id', 'type_name', 'rate_per_day')->get();
        $units = Unit::select('unit_id', 'unit', 'conversion_quantity')->where('conversion_unit','days')->get();
        $taxes = Tax::select('tax_id', 'tax_per')->get();

        return view('admin.sales.sales-quotation.form', compact('customers', 'salesItems', 'productTypes', 'units', 'taxes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesQuotationRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $customerId = $request->customer_id;

            if (!$customerId && $request->customer_name) {
                $customer = Customer::create([
                    'customer_name' => $request->customer_name,
                    'phone_number' => $request->contact_no,
                    'main_address' => $request->address,
                ]);
                $customerId = $customer->customer_id;
            }

            $quotation = SalesQuotation::create([
                'doc_date' => $validated['doc_date'],
                'status' => $validated['status'],
                'customer_id' => $customerId,
                'remarks' => $validated['remarks'],
                'service_type' => implode(',', $validated['service_type'] ?? []),
                'total_amount' => $validated['total_amount'],
                'cgst_amount' => $validated['cgst_amount'] ?? 0,
                'sgst_amount' => $validated['sgst_amount'] ?? 0,
                'igst_amount' => $validated['igst_amount'] ?? 0,
                'grand_amount' => $validated['grand_amount']
            ]);

            foreach ($validated['items'] as $item) {
                $quotation->quotationDetails()->create([
                    'product_type_id' => $item['type'],
                    'sales_item_id' => $item['sales_item_id'],
                    'description' => $item['description'],
                    'unit_id' => $item['unit'],
                    'unit_qty' => $item['unit_qty'],
                    'rate' => $item['rate'],
                    'pallet_qty' => $item['pallet_qty'],
                    'value' => $item['value'],
                    'tax_per' => $item['tax_percent'],
                    'tax_value' => $item['tax_value'],
                    'net_value' => $item['net_value'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.sales.sales-quotation.index')->with('success', 'Sales Quotation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create quotation: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quotation = SalesQuotation::with(['statusUpdates.creator', 'quotationDetails'])->findOrFail($id);

        return view('admin.sales.sales-quotation.view', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quotation = SalesQuotation::with('quotationDetails')->findOrFail($id);

        $customers = Customer::select('customer_id', 'customer_name', 'phone_number')->get();
        $salesItems = SalesItem::select('sales_item_id', 'sales_item_name')->get();
        $productTypes = ProductType::select('product_type_id', 'type_name', 'rate_per_day')->get();
        $units = Unit::select('unit_id', 'unit', 'conversion_quantity')->where('conversion_unit','days')->get();
        $taxes = Tax::select('tax_id', 'tax_per')->get();

        return view('admin.sales.sales-quotation.form', compact('customers', 'salesItems', 'productTypes', 'units', 'taxes' ,'quotation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesQuotationRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $quotation = SalesQuotation::findOrFail($id);

            $customerId = $request->customer_id;

            // Handle new customer creation if needed
            if (!$customerId && $request->customer_name) {
                $customer = Customer::create([
                    'customer_name' => $request->customer_name,
                    'phone_number' => $request->contact_no,
                    'main_address' => $request->address,
                ]);
                $customerId = $customer->customer_id;
            }

            // Update Quotation main fields
            $quotation->update([
                'doc_date' => $validated['doc_date'],
                'status' => $validated['status'],
                'customer_id' => $customerId,
                'remarks' => $validated['remarks'],
                'service_type' => implode(',', $validated['service_type'] ?? []),
                'total_amount' => $validated['total_amount'],
                'cgst_amount' => $validated['cgst_amount'] ?? 0,
                'sgst_amount' => $validated['sgst_amount'] ?? 0,
                'igst_amount' => $validated['igst_amount'] ?? 0,
                'grand_amount' => $validated['grand_amount']
            ]);

            // Delete old quotation details
            $quotation->quotationDetails()->delete();

            // Insert new quotation items
            foreach ($validated['items'] as $item) {
                $quotation->quotationDetails()->create([
                    'product_type_id' => $item['type'],
                    'sales_item_id' => $item['sales_item_id'],
                    'description' => $item['description'],
                    'unit_id' => $item['unit'],
                    'unit_qty' => $item['unit_qty'],
                    'rate' => $item['rate'],
                    'pallet_qty' => $item['pallet_qty'],
                    'value' => $item['value'],
                    'tax_per' => $item['tax_percent'],
                    'tax_value' => $item['tax_value'],
                    'net_value' => $item['net_value'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.sales.sales-quotation.index')->with('success', 'Sales Quotation updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update quotation: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print(string $id)
    {
        $quotation = SalesQuotation::with('quotationDetails')->findOrFail($id);

        return view('admin.sales.sales-quotation.print', compact('quotation'));
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        
        $quotation_id = $request->input('quotation_id');
        $newStatus = $request->input('status');

        $quotation = SalesQuotation::findOrFail($quotation_id);
        $quotation->status = $newStatus;
        $quotation->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}

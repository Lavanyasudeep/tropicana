<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Models\Client;
use App\Models\Master\General\{ Unit, ProductType, Tax};
use App\Models\Master\Sales\{ Customer, SalesItem };
use App\Models\Sales\{ SalesInvoice };
use App\Models\Master\General\Status;

use App\Http\Requests\Sales\SalesInvoiceRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;
use Carbon\Carbon;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = Customer::all();
        $statuses = Status::select('status_name')->where('doc_type', 'sales_invoice')->get();

        if ($request->ajax()) {
            $query = SalesInvoice::with(['customer', 'invoiceDetails.product'])
                ->orderBy('created_at', 'desc');

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if (!empty($search)) {
                        $query->where(function ($q) use ($search) {
                            $q->where('invoice_no', 'like', "%{$search}%")
                                ->orWhereHas('customer', function ($q2) use ($search) {
                                    $q2->where('customer_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('invoiceDetails.product', function ($q2) use ($search) {
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
                ->editColumn('doc_date', function ($invoice) {
                    return $invoice->doc_date ? Carbon::parse($invoice->doc_date)->format('d-m-Y') : '-';
                })
                ->addColumn('amount', function ($invoice) {
                    return $invoice->grand_amount;
                })
                ->addColumn('status', function ($invoice) {
                    return ucfirst($invoice->status);
                })
                ->addColumn('action', function ($invoice) {
                    $act = '';
                    if ($invoice->status === 'created') {
                        $act .= '<a href="' . route('admin.sales.sales-invoice.edit', $invoice->sales_invoice_id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                    $act .= '<a href="' . route('admin.sales.sales-invoice.print', $invoice->sales_invoice_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.sales.sales-invoice.view', $invoice->sales_invoice_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    return $act;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.sales.sales-invoice.index', compact('customers', 'statuses'));
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

        return view('admin.sales.sales-invoice.form', compact('customers', 'salesItems', 'productTypes', 'units', 'taxes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesInvoiceRequest $request)
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

            $invoice = SalesInvoice::create([
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
                $invoice->invoiceDetails()->create([
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

            return redirect()->route('admin.sales.sales-invoice.index')->with('success', 'Sales Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $invoice = SalesInvoice::with(['statusUpdates.creator', 'invoiceDetails'])->findOrFail($id);

        return view('admin.sales.sales-invoice.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = SalesInvoice::with('invoiceDetails')->findOrFail($id);

        $customers = Customer::select('customer_id', 'customer_name', 'phone_number')->get();
        $salesItems = SalesItem::select('sales_item_id', 'sales_item_name')->get();
        $productTypes = ProductType::select('product_type_id', 'type_name', 'rate_per_day')->get();
        $units = Unit::select('unit_id', 'unit', 'conversion_quantity')->where('conversion_unit','days')->get();
        $taxes = Tax::select('tax_id', 'tax_per')->get();

        return view('admin.sales.sales-invoice.form', compact('customers', 'salesItems', 'productTypes', 'units', 'taxes' ,'invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesInvoiceRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $invoice = SalesInvoice::findOrFail($id);

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

            // Update Invoice main fields
            $invoice->update([
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

            // Delete old invoice details
            $invoice->invoiceDetails()->delete();

            // Insert new invoice items
            foreach ($validated['items'] as $item) {
                $invoice->invoiceDetails()->create([
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

            return redirect()->route('admin.sales.sales-invoice.index')->with('success', 'Sales Invoice updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()])->withInput();
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
        $invoice = SalesInvoice::with('invoiceDetails')->findOrFail($id);

        return view('admin.sales.sales-invoice.print', compact('invoice'));
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        
        $invoice_id = $request->input('invoice_id');
        $newStatus = $request->input('status');

        $invoice = SalesInvoice::findOrFail($invoice_id);
        $invoice->status = $newStatus;
        $invoice->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}

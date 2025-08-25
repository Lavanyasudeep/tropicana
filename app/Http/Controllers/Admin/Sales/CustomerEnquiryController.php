<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Models\Master\Sales\Customer;
use App\Models\Sales\CustomerEnquiry;

use App\Http\Requests\Sales\CustomerEnquiryRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;
use Carbon\Carbon;

class CustomerEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CustomerEnquiry::with(['customer'])->orderBy('created_at', 'desc');

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if (!empty($search)) {
                        $query->where(function ($q) use ($search) {
                            $q->where('doc_no', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhereHas('customer', function ($q2) use ($search) {
                                $q2->where('customer_name', 'like', "%{$search}%");
                            });
                        });
                    }

                    if ($request->from_date && $request->to_date) {
                        $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                        $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

                        $query->whereBetween('doc_date', [$from_date, $to_date]);
                    }
                })
                ->editColumn('doc_date', function ($enquiry) {
                    return optional($enquiry->doc_date)
                        ? Carbon::parse($enquiry->doc_date)->format('d/m/Y')
                        : '';
                })
                ->addColumn('customer_name', function ($enquiry) {
                    return optional($enquiry->customer)->customer_name ?? '';
                })
                ->addColumn('type_of_service', function ($enquiry) {
                    return ucwords(str_replace(',',', ',$enquiry->service_type));
                })
                ->addColumn('type_of_item', function ($enquiry) {
                    return ucwords(str_replace(',',', ',$enquiry->item_type));
                })
                ->addColumn('description', function ($enquiry) {
                    return substr($enquiry->description,0,50);
                })
                ->addColumn('status', function ($enquiry) {
                    return ucfirst($enquiry->status ?? 'Open');
                })
                ->addColumn('action', function ($enquiry) {
                    $act = '<a href="' . route('admin.sales.customer-enquiry.print', $enquiry->customer_enquiry_id) . '" target="_blank" class="btn btn-sm btn-print" title="Print" ><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.sales.customer-enquiry.view', $enquiry->customer_enquiry_id) . '" class="btn btn-sm btn-view" title="View" ><i class="fas fa-eye"></i></a>';
                    if($enquiry->status == 'created') {
                        $act .= '<a href="' . route('admin.sales.customer-enquiry.edit', $enquiry->customer_enquiry_id) . '" class="btn btn-sm btn-warning" title="Edit Inactive" ><i class="fas fa-edit"></i></a>';
                    } else {
                        $act .= '<a href="#" class="btn btn-sm btn-warning btn-inactive" title="Edit Inactive" ><i class="fas fa-edit"></i></a>';
                    }
                    //$act .= '&nbsp;<a href="#" class="btn btn-sm btn-delete" data-id="' . $enquiry->customer_enquiry_id . '"><i class="fas fa-trash"></i></a>';
                    return $act;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.sales.customer-enquiry.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::select('customer_id', 'customer_name', 'phone_number')->get();

        return view('admin.sales.customer-enquiry.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerEnquiryRequest $request)
    {
        DB::beginTransaction();

        try {
            // If no customer_id but customer_name exists, create new customer
            $customerId = $request->customer_id;

            if (!$customerId && $request->customer_name) {
                $customer = Customer::create([
                    'customer_name' => $request->customer_name,
                    'phone_number' => $request->contact_no,
                    'main_address' => $request->address,
                ]);
                $customerId = $customer->customer_id;
            }

            $enquiry = CustomerEnquiry::create([
                'doc_date'         => $request->doc_date,
                'status'           => $request->status,
                'customer_id'      => $customerId,
                'service_type'  => implode(',', $request->service_type ?? []),
                'item_type'     => implode(',', $request->item_type ?? []),
                'description' => $request->item_description,
                'remarks'          => $request->remarks,
            ]);

            $this->handleAttachments($enquiry, $request);

            DB::commit();

            return redirect()->route('admin.sales.customer-enquiry.index')
                            ->with('success', 'Customer enquiry created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enquiry = CustomerEnquiry::with(['statusUpdates.creator'])->findOrFail($id);

        return view('admin.sales.customer-enquiry.view', compact('enquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customers = Customer::select('customer_id', 'customer_name', 'phone_number')->get();
        $customerEnquiry = CustomerEnquiry::with('customer')->findOrFail($id);

        return view('admin.sales.customer-enquiry.edit', compact('customers', 'customerEnquiry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerEnquiryRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $enquiry = CustomerEnquiry::findOrFail($id);

            $customerId = $request->customer_id;

            if (!$customerId && $request->customer_name) {
                $customer = Customer::create([
                    'customer_name' => $request->customer_name,
                    'phone_number' => $request->contact_no,
                    'main_address' => $request->address,
                ]);
                $customerId = $customer->id;
            }

            $enquiry->update([
                'doc_date'         => $request->doc_date,
                'status'           => $request->status,
                'customer_id'      => $customerId,
                'service_type'  => implode(',', $request->service_type ?? []),
                'item_type'     => implode(',', $request->item_type ?? []),
                'description' => $request->item_description,
                'remarks'          => $request->remarks,
            ]);

            DB::commit();

            return redirect()->route('admin.sales.customer-enquiry.index')
                            ->with('success', 'Customer enquiry updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
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
        $enquiry = CustomerEnquiry::with('customer')->findOrFail($id);

        return view('admin.sales.customer-enquiry.print', compact('enquiry'));
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        
        $enquiry_id = $request->input('enquiry_id');
        $newStatus = $request->input('status');

        $enquiry = CustomerEnquiry::findOrFail($enquiry_id);
        $enquiry->status = $newStatus;
        $enquiry->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}

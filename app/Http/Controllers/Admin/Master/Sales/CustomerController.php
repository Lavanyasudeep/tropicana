<?php

namespace App\Http\Controllers\Admin\Master\Sales;

use App\Models\{ Company, Branch, Department};
use App\Models\Master\General\{ City, District, Place, PostOffice, State, Country};
use App\Models\Master\Sales\Customer;

use App\Http\Controllers\Controller;

use App\Http\Requests\Master\Sales\CustomerRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Customer::with(['state', 'district'])
                            ->orderBy('created_at', 'desc')
                            ->select('*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('customer_name', 'LIKE', "%$search%")
                                ->orWhereHas('state', function ($q2) use ($search) {
                                    $q2->where('state_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('district', function ($q2) use ($search) {
                                    $q2->where('district_name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('photo', function ($res) {
                    return '<img src="' . $res->photo_url . '" alt="Logo" height="40">';
                })
                ->addColumn('district_name', function ($res) {
                    return $res->district?->district_name;
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                       data-id='" . $res->customer_id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.sales.customer.edit', $res->customer_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.sales.customer.view', $res->customer_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions', 'photo'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.sales.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $countries = Country::select('country_id', 'country_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();
        $cities = City::select('city_id', 'city_name')->get();
        $places = Place::select('place_id', 'place_name')->get();
        $postOffices = PostOffice::select('post_office_id', 'post_office')->get();

        return view('admin.master.sales.customer.form', compact('branches', 'countries', 'states', 'districts', 'cities', 'places', 'postOffices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {

            // Handle password encryption if password provided
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            // Handle photo (if uploading image)
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('customers/photos', 'public');
            }

            // Handle image_trade_license (optional)
            if ($request->hasFile('image_trade_license')) {
                $data['image_trade_license'] = $request->file('image_trade_license')->store('customers/licenses', 'public');
            }

            $customer = Customer::create($data);

            $this->handleAttachments($customer, $request);

            DB::commit();

            return redirect()->route('admin.master.sales.customer.index')->with('success', 'Customer created successfully.');
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
        $customer = Customer::with(['branch','state', 'district', 'city', 'place', 'postoffice', 'shippingState', 'shippingDistrict', 'shippingCity', 'billingState', 'billingDistrict', 'billingCity'])->findOrFail($id);

        return view('admin.master.sales.customer.view', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);

        $branches = Branch::select('branch_id', 'branch_name')->get();
        $countries = Country::select('country_id', 'country_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();
        $cities = City::select('city_id', 'city_name')->get();
        $places = Place::select('place_id', 'place_name')->get();
        $postOffices = PostOffice::select('post_office_id', 'post_office')->get();

        return view('admin.master.sales.customer.form', compact('customer','branches', 'countries', 'states', 'districts', 'cities', 'places', 'postOffices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $customer = Customer::findOrFail($id);

            $data = $request->validated();

            // Update password only if provided
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Photo upload
            if ($request->hasFile('photo')) {
                // Optionally delete old image: Storage::disk('public')->delete($customer->photo);
                $data['photo'] = $request->file('photo')->store('customers/photos', 'public');
            }

            if ($request->hasFile('image_trade_license')) {
                $data['image_trade_license'] = $request->file('image_trade_license')->store('customers/licenses', 'public');
            }

            $customer->update($data);

            DB::commit();

            return redirect()->route('admin.master.sales.customer.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->active = !$company->active;
        $customer->save();

        return response()->json(['success' => true, 'status' => $customer->active]);
    }

    public function getCustomerDetails(Request $request)
    {
        $customer = Customer::where('customer_id', $request->customer_id)
                            ->select('customer_id', 'customer_name', 'phone_number', 'main_address')
                            ->first();

        return response()->json(['customer' => $customer]);
    }
}

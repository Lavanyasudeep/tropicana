<?php

namespace App\Http\Controllers\Admin\Master\Purchase;

use App\Models\{ Company, Branch, Department};
use App\Models\Master\General\{ City, District, Place, PostOffice, State, Country, Tax};
use App\Models\Master\Purchase\Supplier;
use App\Models\Master\Purchase\SupplierCategory;
use App\Models\Master\Purchase\SupplierType;

use App\Http\Controllers\Controller;

use App\Http\Requests\Master\Purchase\SupplierRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Supplier::with(['state', 'district'])
                    ->orderBy('created_date', 'desc')
                    ->select('*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('supplier_name', 'LIKE', "%$search%")
                                ->orWhereHas('state', function ($q2) use ($search) {
                                    $q2->where('state_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('district', function ($q2) use ($search) {
                                    $q2->where('district_name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('district_name', function ($res) {
                    return $res->district?->district_name;
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                       data-id='" . $res->supplier_id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.purchase.supplier.edit', $res->supplier_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.purchase.supplier.view', $res->supplier_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.purchase.supplier.index');
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
        $postOffices = PostOffice::select('post_office_id', 'post_office')->get();
        $supplierCategories = SupplierCategory::select('supplier_category_id', 'supplier_category_name')->get();
        $supplierTypes = SupplierType::select('supplier_type_id', 'supplier_type_name')->get();
        $taxes = Tax::select('tax_id', 'tax_per')->get();

        return view('admin.master.purchase.supplier.form', compact('branches', 'countries', 'states', 'districts', 'cities', 'postOffices', 'supplierCategories', 'supplierTypes', 'taxes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {

            // Handle password encryption if password provided
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $supplier = Supplier::create($data);

            $this->handleAttachments($supplier, $request);

            DB::commit();

            return redirect()->route('admin.master.purchase.supplier.index')->with('success', 'Supplier created successfully.');
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
        $supplier = Supplier::with(['branch', 'country', 'state', 'district', 'city', 'postoffice', 'supplierCategory', 'supplierType'])->findOrFail($id);

        return view('admin.master.purchase.supplier.view', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $branches = Branch::select('branch_id', 'branch_name')->get();
        $countries = Country::select('country_id', 'country_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();
        $cities = City::select('city_id', 'city_name')->get();
        $postOffices = PostOffice::select('post_office_id', 'post_office')->get();
        $supplierCategories = SupplierCategory::select('supplier_category_id', 'supplier_category_name')->get();
        $supplierTypes = SupplierType::select('supplier_type_id', 'supplier_type_name')->get();
        $taxes = Tax::select('tax_id', 'tax_per')->get();

        return view('admin.master.purchase.supplier.form', compact('supplier', 'branches', 'countries', 'states', 'districts', 'cities', 'postOffices', 'supplierCategories', 'supplierTypes', 'taxes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

            $supplier = Supplier::findOrFail($id);

            $data = $request->validated();

            // Update password only if provided
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $supplier->update($data);

            DB::commit();
            
            return redirect()->route('admin.master.purchase.supplier.index')->with('success', 'Supplier updated successfully.');
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
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->back()->with('success', 'Supplier deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);
        $supplier->active = !$supplier->active;
        $supplier->save();

        return response()->json(['success' => true, 'status' => $supplier->active]);
    }

    public function getSupplierDetails(Request $request)
    {
        $supplier = Supplier::where('supplier_id', $request->supplier_id)
                            ->select('supplier_id', 'supplier_name', 'mobile')
                            ->first();

        return response()->json(['supplier' => $supplier]);
    }
}

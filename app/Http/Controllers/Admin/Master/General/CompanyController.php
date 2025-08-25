<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Models\Company;
use App\Models\Master\General\{ City, District, Place, PostOffice, State, Country};

use App\Http\Controllers\Controller;

use App\Http\Requests\Master\General\CompanyRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Company::with(['country', 'state', 'district', 'postoffice'])->select('*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('company_name', 'LIKE', "%$search%")
                                ->orWhereHas('country', function ($q2) use ($search) {
                                    $q2->where('country_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('state', function ($q2) use ($search) {
                                    $q2->where('state_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('district', function ($q2) use ($search) {
                                    $q2->where('district_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('postoffice', function ($q2) use ($search) {
                                    $q2->where('post_office', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('logo', function ($res) {
                    if ($res->logo) {
                        return '<img src="' . asset('storage/' . $res->logo) . '" alt="Logo" height="40">';
                    }
                    return '<span class="text-muted">No Logo</span>';
                })
                ->addColumn('location', function ($res) {
                    return implode(', ', array_filter([
                        optional($res->postoffice)->post_office,
                        optional($res->district)->district_name,
                        optional($res->state)->state_name,
                        optional($res->country)->country_name,
                    ]));
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                       data-id='" . $res->company_id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.general.company.edit', $res->company_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.general.company.view', $res->company_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions', 'logo', 'location'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.general.company.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::select('country_id', 'country_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();
        $postOffices = PostOffice::select('post_office_id', 'post_office')->get();

        return view('admin.master.general.company.form', compact('countries', 'states', 'districts', 'postOffices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB

            'country_id' => 'required|exists:cs_country,country_id',
            'state_id' => 'nullable|exists:cs_state,state_id',
            'district_id' => 'required|exists:cs_district,district_id',
            'post_office_id' => 'nullable|exists:cs_post_office,post_office_id',

            'gstin' => 'nullable|string|max:20|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'tin' => 'nullable|string|max:20',
            'fssai_no' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:15',
            'mobile_number' => 'nullable|string|max:15',

            'email_id' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $data = $request->only([
            'company_name', 'country_id', 'state_id', 'district_id', 'post_office_id',
            'gstin', 'tin', 'fssai_no', 'address', 'phone_number',
            'mobile_number', 'email_id', 'website'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('uploads/company_logos', 'public');
        }

        Company::create($data);

        return redirect()->route('admin.master.general.company.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::with(['country', 'state', 'district', 'postoffice'])->findOrFail($id);

        return view('admin.master.general.company.view', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);

        $countries = Country::select('country_id', 'country_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();
        $postOffices = PostOffice::select('post_office_id', 'post_office')->get();

        return view('admin.master.general.company.form', compact('company', 'countries', 'states', 'districts', 'postOffices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'country_id' => 'required|exists:cs_country,country_id',
            'state_id' => 'required|exists:cs_state,state_id',
            'district_id' => 'required|exists:cs_district,district_id',
            'post_office_id' => 'nullable|exists:cs_post_office,post_office_id',

            'gstin' => 'nullable|string|max:20|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'tin' => 'nullable|string|max:20',
            'fssai_no' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:15',
            'mobile_number' => 'nullable|string|max:15',

            'email_id' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $data = $request->only([
            'company_name', 'country_id', 'state_id', 'district_id', 'post_office_id',
            'gstin', 'tin', 'fssai_no', 'address', 'phone_number',
            'mobile_number', 'email_id', 'website'
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }

            $data['logo'] = $request->file('logo')->store('uploads/company_logos', 'public');
        }

        $company->update($data);

        return redirect()->route('admin.master.general.company.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->back()->with('success', 'Company deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $company = Company::findOrFail($request->id);
        $company->active = !$company->active;
        $company->save();

        return response()->json(['success' => true, 'status' => $company->active]);
    }
}

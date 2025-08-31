<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Models\{ Company, Branch};
use App\Models\Master\General\{ City, District, Place, PostOffice, State, Country};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Branch::with(['company', 'state', 'district'])->select('*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('branch_name', 'LIKE', "%$search%")
                                ->orWhereHas('company', function ($q2) use ($search) {
                                    $q2->where('company_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('state', function ($q2) use ($search) {
                                    $q2->where('state_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('district', function ($q2) use ($search) {
                                    $q2->where('district_name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('location', function ($res) {
                    return implode(', ', array_filter([
                        $res->pincode,
                        optional($res->company?->postoffice)->post_office,
                        optional($res->district)->district_name,
                        optional($res->state)->state_name,
                        optional($res->company?->country)->country_name,
                    ]));
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='" . $res->branch_id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.general.branch.edit', $res->branch_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.general.branch.view', $res->branch_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions', 'location'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.general.branch.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::select('company_id', 'company_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();

        return view('admin.master.general.branch.form', compact('companies', 'states', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',

            //'country_id' => 'required|exists:cs_country,country_id',
            'state_id' => 'nullable|exists:cs_state,state_id',
            'district_id' => 'required|exists:cs_district,district_id',
            'pincode' => 'required',

            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:15',

            'email_id' => 'nullable|email|max:255',
        ]);

        $data = $request->only([
            'branch_name', 'company_id', 'state_id', 'district_id', 'pincode',
            'address', 'phone_number', 'email_id',
        ]);

        Branch::create($data);

        return redirect()->route('admin.master.general.branch.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::with(['company', 'state', 'district'])->findOrFail($id);

        return view('admin.master.general.branch.view', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branch = Branch::findOrFail($id);

        $companies = Company::select('company_id', 'company_name')->get();
        $states = State::select('state_id', 'state_name')->get();
        $districts = District::select('district_id', 'district_name')->get();

        return view('admin.master.general.branch.form', compact('branch', 'companies', 'states', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->back()->with('success', 'Branch deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $branch = Branch::findOrFail($request->id);
        $branch->active = !$branch->active;
        $branch->save();

        return response()->json(['success' => true, 'status' => $branch->active]);
    }
}

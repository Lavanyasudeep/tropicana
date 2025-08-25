<?php

namespace App\Http\Controllers\Admin\Master\HR;

use App\Models\Master\HR\{ Employee, Designation };
use App\Models\{ Company, Branch, Department};

use App\Http\Controllers\Controller;

use App\Http\Requests\HR\EmployeeRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Employee::with(['company', 'branch', 'designation'])->select('*');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('first_name', 'LIKE', "%$search%")
                                ->orWhere('last_name', 'LIKE', "%$search%")
                                ->orWhereHas('company', function ($q2) use ($search) {
                                    $q2->where('company_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('branch', function ($q2) use ($search) {
                                    $q2->where('branch_name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('designation', function ($q2) use ($search) {
                                    $q2->where('designation_name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('employee', function ($res) {
                    return '<img src="' . $res->photo_url . '" alt="Logo" height="40">'.$res->employee_name;
                })
                ->addColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                       data-id='" . $res->employee_id . "' >" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.master.hr.employee.edit', $res->employee_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.master.hr.employee.view', $res->employee_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['Status', 'actions', 'employee'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.hr.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::select('company_id', 'company_name')->get();
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $departments = Department::select('department_id', 'department_name')->get();
        $designations = Designation::select('designation_id', 'designation_name')->get();

        return view('admin.master.hr.employee.form', compact('companies', 'branches', 'departments', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();

        $employee = new Employee($validated);

        if ($request->hasFile('photo')) {
            $employee->photo = $request->file('photo')->store('employee_photos', 'public');
        }

        $employee->save();

        return redirect()->route('admin.master.hr.employee.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['company', 'branch', 'department', 'designation'])->findOrFail($id);

        return view('admin.master.hr.employee.view', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with(['company', 'branch', 'department', 'designation'])->findOrFail($id);

        $companies = Company::select('company_id', 'company_name')->get();
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $departments = Department::select('department_id', 'department_name')->get();
        $designations = Designation::select('designation_id', 'designation_name')->get();

        return view('admin.master.hr.employee.form', compact('employee', 'companies', 'branches', 'departments', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, $id)
    {
        $validated = $request->validated();

        $employee = Employee::findOrFail($id);
        $employee->fill($validated);

        if ($request->hasFile('photo')) {
            $employee->photo = $request->file('photo')->store('employee_photos', 'public');
        }

        $employee->save();

        return redirect()->route('admin.master.hr.employee.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $employee = Employee::findOrFail($request->id);
        $employee->active = !$company->active;
        $employee->save();

        return response()->json(['success' => true, 'status' => $employee->active]);
    }
}

<?php

namespace App\Http\Controllers\Admin\Master\Accounting;

use App\Models\{Company};
use App\Models\Master\Accounting\{Analytical, ChartOfAccount};

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;

class AnalyticalController extends Controller
{
    public $FPATH;

    public function __construct()
    {
        $this->FPATH = 'admin.master.accounting.analytical';
    }
    
    public function index(Request $request)
    {
        $data = Analytical::with(['chartOfAccount'])->orderBy('created_at', 'desc');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('quick_search'))) {
                        $search = $request->get('quick_search');
                        // $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('analytical_code', 'LIKE', "%$search%")
                            ->orWhere('account_code', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('account_name', function ($res) {
                    return $res->chartOfAccount->account_name;
                })
                ->addColumn('active', function ($res) {
                    return $res->active? 'Yes' : 'No';
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route($this->FPATH.'.edit', $res->analytical_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route($this->FPATH.'.view', $res->analytical_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['account_name', 'active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        $FPATH =$this->FPATH;
        return view($this->FPATH.'.index',compact('FPATH'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::select('company_id', 'company_name')->get();
        $chart_of_account = ChartOfAccount::select('account_id', 'account_name', 'account_code')->whereNotNull('account_code')->orderBy('account_code')->get();

        return view($this->FPATH.'.form', compact('companies', 'chart_of_account'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'    => ['required', 'integer'],
            'analytical_code'     => ['required', 'string'],
            'account_code'     => ['required', 'string']
        ]);

        $analytical = new Analytical();
        $analytical->fill($validated);
        $analytical->active = 1;
        $analytical->created_by = auth()->user()->id;
        $analytical->save();

        return redirect()->route($this->FPATH.'.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $analytical = Analytical::with(['company', 'chartOfAccount', 'createdBy', 'updatedBy'])->findOrFail($id);

        return view($this->FPATH.'.view', compact('analytical'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companies = Company::select('company_id', 'company_name')->get();
        $chart_of_account = ChartOfAccount::select('account_id', 'account_name', 'account_code')->get();
        $analytical = Analytical::with(['chartOfAccount'])->findOrFail($id);

        return view($this->FPATH.'.form', compact('analytical', 'companies', 'chart_of_account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $analytical = Analytical::findOrFail($id);

        $validated = $request->validate([
            'company_id'    => ['required', 'integer'],
            'analytical_code'     => ['required', 'string'],
            'account_code'     => ['required', 'string']
        ]);

        $analytical->fill($validated);
        $analytical->active = $request->active?? 0;
        $analytical->updated_by = auth()->user()->id;
        $analytical->save();

        return redirect()->route($this->FPATH.'.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $analytical = Analytical::findOrFail($id);
        $analytical->delete();

        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}

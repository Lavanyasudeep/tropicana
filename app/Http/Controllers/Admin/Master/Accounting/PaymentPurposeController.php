<?php

namespace App\Http\Controllers\Admin\Master\Accounting;

use App\Models\{Company};
use App\Models\Master\Accounting\{PaymentPurpose, ChartOfAccount};

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;

class PaymentPurposeController extends Controller
{
    public $FPATH;

    public function __construct()
    {
        $this->FPATH = 'admin.master.accounting.payment-purpose';
    }
    
    public function index(Request $request)
    {
        $data = PaymentPurpose::with(['bSheetAccount', 'expAccount'])->orderBy('created_at', 'desc');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('quick_search'))) {
                        $search = $request->get('quick_search');
                        // $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('purpose_name', 'LIKE', "%$search%")
                            ->orWhereHas('bSheetAccount', function ($q2) use ($search) {
                                $q2->where('account_name', 'like', "%{$search}%");
                            })
                             ->orWhereHas('expAccount', function ($q2) use ($search) {
                                $q2->where('account_name', 'like', "%{$search}%");
                            });
                        });
                    }
                })
                ->addColumn('bsheet_account_name', function ($res) {
                    return $res->bSheetAccount?->account_name;
                })
                ->addColumn('exp_account_name', function ($res) {
                    return $res->expAccount?->account_name;
                })
                ->addColumn('active', function ($res) {
                    return $res->active? 'Yes' : 'No';
                })
                ->addColumn('actions', function ($res) {
                    $act = '';
                    $act .= '<a href="'.route($this->FPATH.'.edit', $res->purpose_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '&nbsp;<a href="' . route($this->FPATH.'.view', $res->purpose_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    
                    return $act;
                })
                ->rawColumns(['bsheet_account_name', 'exp_account_name', 'active', 'actions'])
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
            'purpose_name'     => ['required', 'string'],
            'bsheet_account_code'     => ['required', 'string'],
            'exp_account_code'     => ['required', 'string']
        ]);

        $paymentPurpose = new PaymentPurpose();
        $paymentPurpose->fill($validated);
        $paymentPurpose->active = 1;
        $paymentPurpose->save();

        return redirect()->route($this->FPATH.'.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentPurpose = PaymentPurpose::with(['company', 'bSheetAccount', 'expAccount', 'createdBy', 'updatedBy'])->findOrFail($id);

        return view($this->FPATH.'.view', compact('paymentPurpose'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companies = Company::select('company_id', 'company_name')->get();
        $chart_of_account = ChartOfAccount::select('account_id', 'account_name', 'account_code')->get();
        $paymentPurpose = PaymentPurpose::with(['bSheetAccount', 'expAccount'])->findOrFail($id);

        return view($this->FPATH.'.form', compact('paymentPurpose', 'companies', 'chart_of_account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paymentPurpose = PaymentPurpose::findOrFail($id);

        $validated = $request->validate([
            'company_id'    => ['required', 'integer'],
            'purpose_name'     => ['required', 'string'],
            'bsheet_account_code'     => ['required', 'string'],
            'exp_account_code'     => ['required', 'string']
        ]);

        $paymentPurpose->fill($validated);
        $paymentPurpose->active = $request->active?? 0;
        $paymentPurpose->save();

        return redirect()->route($this->FPATH.'.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentPurpose = PaymentPurpose::findOrFail($id);
        $paymentPurpose->delete();

        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}

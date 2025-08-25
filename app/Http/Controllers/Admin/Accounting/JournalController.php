<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Models\{ Branch, Department };
use App\Models\Master\Purchase\Supplier;
use App\Models\Master\Accounting\BankMaster;
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Accounting\Analytical;
use App\Models\Master\Accounting\PaymentPurpose;
use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\Journal;
use App\Models\Accounting\PaymentSettlement;
use App\Models\Accounting\PaymentVoucher;
use App\Models\Master\General\Status;

use App\Models\Common\StatusUpdate;
use App\Models\Client;

use App\Services\Accounting\LedgerService;

use App\Enums\VoucherType;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use DataTables;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $departments = Department::select('department_id', 'department_name')->get();
        $statuses = Status::select('status_name')->where('doc_type', 'journal')->get();
        
        if ($request->ajax()) {
            $query = Journal::with(['journalDetails', 'branch', 'department'])
                            ->orderBy('created_at', 'desc');
            
            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if ($search != '') {
                        $query->where(function ($q) use ($search) {
                            $q->where('account_code', 'like', "%{$search}%")
                              ->orWhere('analytical_code', 'like', "%{$search}%");
                        });
                    }
                    
                    if ($request->from_date && $request->to_date) {
                        $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                        $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

                        $query->whereBetween('created_at', [
                                    $from_date,
                                    $to_date
                                ]);
                    }

                    if ($request->filled('branch_id')) {
                        $query->where('branch_id', $request->branch_id);
                    }

                    if ($request->filled('department_id')) {
                        $query->where('department_id', $request->department_id);
                    }

                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }
                })
                ->editColumn('doc_date', function ($journal) {
                    return $journal->formatDate('doc_date'); 
                })
                ->addColumn('accounts', function ($journal) {
                    return $journal->journalDetails
                        ->map(function ($detail) {
                            return $detail->account->account_name . ' - ' . $detail->account_code;
                        })
                        ->implode(', ');
                })
                ->addColumn('narrations', function ($journal) {
                    return $journal->journalDetails
                        ->map(function ($detail) {
                            return $detail->narration;
                        })
                        ->implode(', ');
                })
                // ->addColumn('supplier_name', function ($payment) {
                //     return optional($payment->payee)->supplier_name
                //         ? ucfirst($payment->payee->supplier_name)
                //         : '';
                // })
                ->addColumn('action', function ($journal) {
                    //$act = '<a href="#" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act = '<a href="' . route('admin.accounting.journal.print', $journal->journal_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.accounting.journal.view', $journal->journal_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    $act .= '&nbsp;<a href="#" class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></a>';
                    return $act;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.accounting.journal.index', compact('branches', 'departments', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::select('branch_id', 'branch_name')->get();
        $departments = Department::select('department_id', 'department_name')->get();
        $accounts = ChartOfAccount::selectRaw("account_code as value, CONCAT(account_name, ' - ', account_code) as label")
                ->where('company_id', auth()->user()->company_id)
                ->where('active', 1)
                ->orderBy('account_code')
                ->get();

        $analytical = Analytical::select('analytical_code')
                            ->where('company_id', auth()->user()->company_id)
                            ->where('active', 1)
                            ->get();

        return view('admin.accounting.journal.create', compact('branches', 'departments', 'accounts', 'analytical'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Validate inputs
            $validated = $request->validate([
                'doc_date'      => 'required|date',
                'branch_id'     => 'required|integer',
                'department_id' => 'required|integer',
                'ledger'        => 'required|array',
                'account_code'  => 'required|array',
                'debit'         => 'required|array',
                'credit'        => 'required|array',
            ]);

            // 2. Calculate total amount (sum of debit)
            $totalAmount = collect($request->debit)->sum();

            // 3. Insert into cs_journal (master)
            $journalId = DB::table('cs_journal')->insertGetId([
                'company_id'   => auth()->user()->company_id ?? null,
                'branch_id'    => $request->branch_id,
                'department_id'=> $request->department_id,
                'doc_date'     => $request->doc_date,
                'doc_date_time'=> now(),
                'amount'       => $totalAmount,
                'status'       => 'Created'
            ]);

            // 4. Insert into cs_journal_detail (child rows)
            foreach ($request->ledger as $index => $ledger) {
                $debit  = (float) ($request->debit[$index] ?? 0);
                $credit = (float) ($request->credit[$index] ?? 0);

                // Determine tran_type (D = Debit, C = Credit)
                if ($debit > 0) {
                    $amount   = $debit;
                    $tranType = 'D';
                } elseif ($credit > 0) {
                    $amount   = $credit;
                    $tranType = 'C';
                } else {
                    continue; // skip empty row
                }

                DB::table('cs_journal_detail')->insert([
                    'journal_id'      => $journalId,
                    'account_type'    => $ledger,
                    'account_code'    => $request->account_code[$index] ?? null,
                    'analytical_code' => $request->analytical_code[$index] ?? null,
                    'amount'          => $amount,
                    'tran_type'       => $tranType,
                    'narration'       => $request->narration[$index] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.accounting.journal.index')
                            ->with('success', 'Journal entry created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $journal = Journal::with(['journalDetails', 'branch', 'department', 'statusUpdates.creator'])->findOrFail($id);

        return view('admin.accounting.payment.view', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
         DB::beginTransaction();

        try {
            $journal = Journal::with('journalDetails')->findOrFail($id);
            $journal->status = 'cancelled';
            $journal->save();

            DB::commit();
            return response()->json(['message' => 'Journal Entry cancelled successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to cancel Journal Entry.',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    public function changeStatus(Request $request)
    {
        $journal_id = $request->input('journal_id');
        $status = $request->input('status');

        $journal = Journal::findOrFail($journal_id);
        $journal->status = $status;

        $journal->stampUserByStatus();
        
        echo true;
    }

    public function print($id)
    {
        $journal = Journal::findOrFail($id);

        return view('admin.accounting.journal.print', compact('journal'));
    }
}

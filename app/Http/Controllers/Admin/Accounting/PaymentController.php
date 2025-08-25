<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Models\Master\Purchase\Supplier;
use App\Models\Master\Accounting\BankMaster;
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Accounting\Analytical;
use App\Models\Master\Accounting\PaymentPurpose;
use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\PaymentSettlement;
use App\Models\Accounting\PaymentVoucher;

use App\Models\Common\StatusUpdate;
use App\Models\Client;

use App\Services\Accounting\LedgerService;

use App\Enums\VoucherType;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::select('client_id', 'client_name')->get();
        
        if ($request->ajax()) {
            $query = PaymentVoucher::with(['payee', 'fromAccount', 'toAccount'])
                            ->orderBy('created_at', 'desc');
            
            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if ($search != '') {
                        $query->where(function ($q) use ($search) {
                            $q->where('doc_no', 'like', "%{$search}%")
                                ->orWhereHas('supplier', function ($q2) use ($search) {
                                    $q2->where('supplier_name', 'like', "%{$search}%");
                                });
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
                })
                ->editColumn('doc_date', function ($payment) {
                    return $payment->formatDate('doc_date'); 
                })
                ->addColumn('from_account', function ($payment) {
                    return optional($payment->chartOfAccount)
                        ? $payment->fromAccount->account_name . ' - ' . $payment->fromAccount->account_code
                        : '';
                })
                ->addColumn('to_account', function ($payment) {
                    return optional($payment->chartOfAccount)
                        ? $payment->toAccount->account_name . ' - ' . $payment->toAccount->account_code
                        : '';
                })
                ->addColumn('supplier_name', function ($payment) {
                    return optional($payment->payee)->supplier_name
                        ? ucfirst($payment->payee->supplier_name)
                        : '';
                })
                ->addColumn('transaction_type', function ($payment) {
                    return optional($payment->transactionType)->transaction_type
                        ? ucfirst($payment->transactionType->transaction_type)
                        : '';
                })
                ->addColumn('voucher_type_label', function ($payment) {
                    // return VoucherType::from($payment->voucher_type)->label();
                    return $payment->voucher_type_label;

                })
                ->addColumn('action', function ($payment) {
                    //$act = '<a href="#" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act = '<a href="' . route('admin.accounting.payment.print', $payment->payment_voucher_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.accounting.payment.view', $payment->payment_voucher_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    $act .= '&nbsp;<a href="#" class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></a>';
                    return $act;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.accounting.payment.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accountFrom = ChartOfAccount::selectRaw("account_code as value, CONCAT(account_name, ' - ', account_code) as label")
                ->where('company_id', auth()->user()->company_id)
                ->where('active', 1)
                ->where('is_cash_or_bank', 1)
                ->orderBy('account_code')
                ->get();

        $accountTo = ChartOfAccount::selectRaw("account_code as value, CONCAT(account_name, ' - ', account_code) as label")
                ->where('company_id', auth()->user()->company_id)
                ->where('active', 1)
                ->orderBy('account_code')
                ->get();

        $banks = BankMaster::with('chartOfAccount:account_code,account_name')
                            ->select('bank_master_id', 'bank_name', 'account_code')
                            ->where('active', 1)
                            ->where('company_id', auth()->user()->company_id)
                            // ->where('branch_id', auth()->user()->branch_id)
                            ->get()
                            ->map(function ($bank) {
                                return (object) [
                                    'bank_master_id' => $bank->bank_master_id,
                                    'bank_name' => $bank->bank_name,
                                    'account_code' => $bank->account_code,
                                    'account_name' => optional($bank->chart_of_account)->account_name,
                                ];
                            });

        $tranTypes = TransactionType::where('active', 1)
                            ->where('company_id', auth()->user()->company_id)
                            ->whereNotIn(DB::raw('LOWER(transaction_type)'), ['card', 'googlepay'])
                            ->get();
        
        $voucherTypes = VoucherType::cases();

        $analytical = Analytical::select('analytical_code')
                            ->where('company_id', auth()->user()->company_id)
                            ->where('active', 1)
                            ->get();
                
        $suppliers = Supplier::select('supplier_id', 'supplier_name')->orderBy('supplier_name')->get();
        
        $purposes = PaymentPurpose::where('active', 1)
                            ->where('company_id', auth()->user()->company_id)
                            ->get();

        return view('admin.accounting.payment.create', compact('suppliers', 'accountFrom', 'accountTo', 'banks', 'tranTypes', 'analytical', 'voucherTypes', 'purposes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_date' => 'required|date',
            'ref_date' => 'nullable|date',
            'supplier_id' => 'nullable|exists:cs_supplier,supplier_id',
            'transaction_type' => 'required|string',
            'from_account_code' => 'required|array',
            'from_account_code.*' => 'required|string|max:30',
            'to_account_code' => 'required|array',
            'to_account_code.*' => 'required|string|max:30',
            'analytical_code' => 'nullable|array',
            'analytical_code.*' => 'nullable|string|max:250',
            'bank_master_id.*' => 'nullable|integer',
            'supplier_bank.*' => 'nullable|string|max:250',
            'narration.*' => 'nullable|string|max:250',
            'requested_amount' => 'required|numeric|min:0',
            'ref_no' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();

        try {
            $payment = new PaymentVoucher();
        
            $payment->doc_date = $request->doc_date;
            $payment->doc_date_time = Carbon::now();

            $payment->reference_no = $request->ref_no;
            $payment->reference_date = $request->ref_date;

            $payment->voucher_type = $request->voucher_type;
            $payment->transaction_type = $request->transaction_type;
            $payment->payment_type = $request->boolean('is_advance') ? 'advance' : 'full';
            $payment->is_advance = $request->boolean('is_advance');
            $payment->purpose_id = $request->purpose_id;
            $payment->status = $request->status;
            $payment->supplier_id = $request->supplier_id;
            $payment->remarks = $request->remarks;

            $payment->to_account_code = $request->to_account_code[0] ?? null;
            $payment->supplier_bank = $request->supplier_bank[0] ?? null;
            $payment->to_analytical_code = $request->analytical_code[0] ?? null;
            $narration_to = $request->narration[0] ?? null;

            $payment->from_account_code = $request->from_account_code[0] ?? null;
            $payment->bank_master_id = $request->bank_master_id[0] ?? null;
            $payment->from_analytical_code = $request->analytical_code[1] ?? null;
            $narration_from = $request->narration[1] ?? null;

            if ($request->status === 'created') {
                $payment->requested_amount = $request->requested_amount;
            } elseif ($request->status === 'approved') {
                $payment->approved_amount = $request->approved_amount;
                $payment->approved_date = date('Y-m-d');
            } elseif ($request->status === 'paid') {
                $payment->paid_amount = $request->paid_amount;
                $payment->paid_date = date('Y-m-d');
            } elseif ($request->status === 'settled') {
                $payment->settled_amount = $request->settled_amount;
            }

            $payment->save();

            DB::commit();
            return redirect()->route('admin.accounting.payment.index')->with('success', 'Payment Voucher created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to submit Payment Voucher',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = PaymentVoucher::with(['payee', 'bankMaster', 'fromAccount', 'toAccount', 'statusUpdates.creator', 'settlements'])->findOrFail($id);
        $accountTo = [];

        if($payment->is_advance) {
            $accountTo = ChartOfAccount::query()
                ->selectRaw("account_code as value, CONCAT(account_name, ' - ', account_code) as label")
                ->where('company_id', $payment->company_id)
                ->where('active', 1)
                ->whereIn('level_1_id', [3, 7])
                ->orderBy('account_code')
                ->get();
        } 

        $analyticals = Analytical::select('analytical_code')
                        ->where('company_id', auth()->user()->company_id)
                        ->where('active', 1)
                        ->get();

        $paymentAmounts = [
            'requested' => $payment->requested_amount,
            'approved' => $payment->approved_amount,
            'paid'     => $payment->paid_amount,
            'settled'  => $payment->settled_amount,
        ];

        return view('admin.accounting.payment.view', compact('payment', 'paymentAmounts', 'accountTo', 'analyticals'));
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
            $payment = PaymentVoucher::with('settlements')->findOrFail($id);
            $payment->status = 'cancelled';
            $payment->save();

            $payment->settlements->each(function ($settlement) {
                $settlement->status = 'cancelled';
                $settlement->save();
            });

            DB::commit();
            return response()->json(['message' => 'Payment Voucher cancelled successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to cancel Payment Voucher.',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    public function settle(Request $request, string $id)
    {
        $request->validate([
            'settlement.ledger_account' => 'required|array',
            'settlement.analytical_code' => 'required|array',
            'settlement.debit' => 'required|array',
            'settlement.narration' => 'nullable|array',
        ]);

        $settleDate = date('Y-m-d');
        
        $ledgerAccounts = $request->input('settlement.ledger_account');
        $analyticalCode = $request->input('settlement.analytical_code');
        $amounts_debit = $request->input('settlement.debit');
        $amounts_credit = $request->input('settlement.credit');
        $narrations = $request->input('settlement.narration');

        $total = array_sum(array_map(fn($v) => floatval($v), $amounts_debit));

        $payment = PaymentVoucher::findOrFail($id);

        if ($total > $payment->requested_amount) {
            return back()->withErrors(['settlement' => 'Total settlement amount exceeds the requested amount.'])->withInput();
        }

        DB::beginTransaction();

        try {

            $settle_post = [];
            foreach ($ledgerAccounts as $index => $accountCode) {
                $amount = ($amounts_debit[$index]>0? $amounts_debit[$index] : $amounts_credit[$index]*-1);
                $tran_type = ($amount>0? 'DR' : 'CR');

                PaymentSettlement::create([
                    'company_id' => $payment->company_id,
                    'branch_id' => $payment->branch_id,
                    'voucher_id' => $id,
                    'account_code' => $accountCode,
                    'analytical_code' => $analyticalCode[$index]?? null,
                    'amount' => $amount,
                    'tran_type' => $tran_type,
                    'settle_date' => $settleDate,
                    'narration' => $narrations[$index] ?? null,
                    'remarks' => null,
                ]);

                $settle_post[] = [
                    'account_code' => $accountCode,
                    'other_type' => 'settlement',
                    'amount' => $amount,
                    'tran_type' => $tran_type,
                    'analytical_code' => $analyticalCode[$index]?? null,
                    'narration' => $narrations[$index] ?? null,
                ];
            }

            $payment->stampUserByStatus();
        
            $payment->status = 'settled';
            $payment->settled_amount = $total;
            $payment->save();

            // Posting
            LedgerService::post([
                'company_id' => $payment->company_id,
                'branch_id' => $payment->branch_id,
                'doc_type' => $payment->doc_type,
                'doc_no' => $payment->doc_no,
                'doc_date' => $payment->doc_date,
                'doc_date_time' => $payment->doc_date_time,
                'tran_date' => $settleDate,
            ], $settle_post);

            DB::commit();
            return redirect()->back()->with('success', 'Payment settled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to submit Payment Settlement',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    public function getLedgerAccount(Request $request)
    {
        $user = auth()->user();

        $isAdvance = filter_var($request->input('advance'), FILTER_VALIDATE_BOOLEAN);
        $tranType = $request->input('tranType');
        $purposeId = $request->input('purposeId');
        
        // 1️⃣ Get Transaction Type
        $tranTypeModel = TransactionType::query()
            ->where('active', 1)
            ->where('company_id', $user->company_id)
            ->whereRaw('LOWER(transaction_type) = ?', [strtolower($tranType)])
            ->whereNotIn(DB::raw('LOWER(transaction_type)'), ['card', 'googlepay'])
            ->first();

        // 2️⃣ Get Payment Purpose
       if ($purposeId !== '' && $purposeId !== null) {
            $purpose = PaymentPurpose::where('active', 1)
                ->where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id)
                ->where('purpose_id', $purposeId)
                ->first();

            if ($purpose) {
                $expCodes = [$purpose->exp_account_code];
                $bsheetCodes = [$purpose->bsheet_account_code];
                $purpose = $purpose->toArray();
            } else {
                $expCodes = [];
                $bsheetCodes = [];
                $purpose = null;
            }
        } else {
            $purposes = PaymentPurpose::where('active', 1)
                ->where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id)
                ->get();

            $expCodes = $purposes->pluck('exp_account_code')->filter()->unique()->values()->all();
            $bsheetCodes = $purposes->pluck('bsheet_account_code')->filter()->unique()->values()->all();

            $purpose = $purposes->map(function ($item) {
                return [
                    'purpose_id' => $item->purpose_id,
                    'purpose_name' => $item->purpose_name,
                    'bsheet_account_code' => $item->bsheet_account_code,
                    'exp_account_code' => $item->exp_account_code,
                ];
            })->toArray();
        }

        // if (!$tranTypeModel || !$purpose) {
        //     return response()->json([
        //         'fromAccount' => [],
        //         'toAccount' => [],
        //     ]);
        // }

        // 3️⃣ Common SELECT
        $select = "account_code as value, CONCAT(account_name, ' - ', account_code) as label";

        // 4️⃣ From Account
        $accountFrom = ChartOfAccount::query()
            ->selectRaw($select)
            ->where('company_id', $user->company_id)
            ->when($tranType != '', fn ($q) => $q->where('account_code', $tranTypeModel->account_code))
            ->where('active', 1)
            ->where('is_cash_or_bank', 1)
            ->orderBy('account_code')
            ->get();
       
        // 5️⃣ To Account — use when() for conditional whereIn
        $accountTo = ChartOfAccount::query()
                    ->selectRaw($select)
                    ->where('company_id', $user->company_id)
                    ->where('active', 1)
                    ->when(!$isAdvance && $purpose && count($expCodes), fn($q) => 
                        $q->whereIn('account_code', $expCodes))
                    ->when($isAdvance && $purpose && count($bsheetCodes), fn($q) => 
                        $q->whereIn('account_code', $bsheetCodes))
                    ->orderBy('account_code')
                    ->get();

        return response()->json([
            'fromAccount' => $accountFrom,
            'toAccount' => $accountTo,
        ]);
    }

    public function getLedgerAccountBalance(Request $request)
    {
        $request->validate([
            'accountCode' => 'required|string'
        ]);

        $balance = GeneralLedger::where('branch_id', auth()->user()->branch_id)
                    ->where('account_code', $request->AccountCode)
                    ->sum('Amount')??0;

        return response()->json([
                'account_balance' => $balance
            ]);
    }

    public function getPaymentPurpose(Request $request)
    {
        $isAdvance = filter_var($request->input('is_advance'), FILTER_VALIDATE_BOOLEAN);
       
        $purpose = PaymentPurpose::where('active', 1)
            ->where('company_id', auth()->user()->company_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->when($isAdvance == true, fn($q) =>
                $q->whereRaw('LOWER(purpose_name) like ?', ['%advance%']))
            ->when($isAdvance == false, fn($q) =>
                $q->whereRaw("LOWER(purpose_name) NOT LIKE '%advance%'"))
            ->get()
            ->map(fn($item) => [
                'purpose_id' => $item->purpose_id,
                'purpose_name' => $item->purpose_name,
            ])
            ->toArray();

        return response()->json([
                'purpose' => $purpose
            ]);
    }

    public function changeStatus(Request $request)
    {
        $payment_id = $request->input('payment_id');
        $status = $request->input('status');

        $payment = PaymentVoucher::findOrFail($payment_id);
        $payment->status = $status;
        
        if ($status === 'created') {
            $payment->requested_amount = $payment->requested_amount;
        } elseif ($status === 'approved') {
            $payment->approved_amount = $payment->requested_amount;
        } elseif ($status === 'paid') {
            $payment->paid_amount = $payment->requested_amount;
            $payment->paid_date = date('Y-m-d');
        } elseif ($status === 'settled') {
            $payment->settled_amount = $payment->requested_amount;
        }
        $payment->save();

        if($status === 'paid') {
            LedgerService::post([
                'company_id' => $payment->company_id,
                'branch_id' => $payment->branch_id,
                'doc_type' => $payment->doc_type,
                'doc_no' => $payment->doc_no,
                'doc_date' => $payment->doc_date,
                'doc_date_time' => $payment->doc_date_time,
                'tran_date' => $payment->paid_date,
            ], [
                [
                    'account_code' => $payment->to_account_code,
                    'tran_type' => 'DR',
                    'other_type' => ($payment->supplier_id == 1? 'analytical' : 'supplier'),
                    'record_id' => ($payment->supplier_id == 1? $payment->to_analytical_code : $payment->supplier_id),
                    'amount' => $payment->requested_amount,
                    'analytical_code' => $payment->to_analytical_code,
                    'narration' => $payment->to_narration,
                ],
                [
                    'account_code' => $payment->from_account_code,
                    'tran_type' => 'CR',
                    'other_type' => ($payment->supplier_id == 1? 'analytical' : 'supplier'),
                    'record_id' => ($payment->supplier_id == 1? $payment->from_analytical_code : $payment->supplier_id),
                    'amount' => $payment->requested_amount*-1,
                    'analytical_code' => $payment->from_analytical_code,
                    'narration' => $payment->from_narration,
                ]
            ]);
        }

        $payment->stampUserByStatus();
        
        echo true;
    }

    public function print($id)
    {
        $payment = PaymentVoucher::findOrFail($id);

        return view('admin.accounting.payment.print', compact('payment'));
    }
}

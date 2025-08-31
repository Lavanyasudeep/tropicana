<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Models\Master\Sales\Customer;
use App\Models\Master\Accounting\BankMaster;
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Accounting\Analytical;
use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\ReceiptSettlement;
use App\Models\Accounting\ReceiptVoucher;

use App\Models\Common\StatusUpdate;
use App\Models\Client;

use App\Services\Accounting\LedgerService;

use App\Enums\VoucherType;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use DataTables;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::select('client_id', 'client_name')->get();
        
        if ($request->ajax()) {
            $query = ReceiptVoucher::with(['payee', 'fromAccount', 'toAccount'])
                            ->orderBy('created_at', 'desc');
            
            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = $request->get('quick_search');

                    if ($search != '') {
                        $query->where(function ($q) use ($search) {
                            $q->where('doc_no', 'like', "%{$search}%")
                                ->orWhereHas('customer', function ($q2) use ($search) {
                                    $q2->where('customer_name', 'like', "%{$search}%");
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
                ->editColumn('doc_date', function ($receipt) {
                    return $receipt->formatDate('doc_date'); 
                })
                ->addColumn('from_account', function ($receipt) {
                    return optional($receipt->chartOfAccount)
                        ? $receipt->fromAccount->account_name . ' - ' . $receipt->fromAccount->account_code
                        : '';
                })
                ->addColumn('to_account', function ($receipt) {
                    return optional($receipt->chartOfAccount)
                        ? $receipt->toAccount->account_name . ' - ' . $receipt->toAccount->account_code
                        : '';
                })
                ->addColumn('customer_name', function ($receipt) {
                    return optional($receipt->payee)->customer_name
                        ? ucfirst($receipt->payee->customer_name)
                        : '';
                })
                ->addColumn('transaction_type', function ($receipt) {
                    return optional($receipt->transactionType)->transaction_type
                        ? ucfirst($receipt->transactionType->transaction_type)
                        : '';
                })
                ->addColumn('voucher_type_label', function ($receipt) {
                    // return VoucherType::from($receipt->voucher_type)->label();
                    return $receipt->voucher_type_label;

                })
                ->addColumn('action', function ($receipt) {
                    //$act = '<a href="#" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act = '<a href="' . route('admin.accounting.receipt.print', $receipt->receipt_voucher_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '&nbsp;<a href="' . route('admin.accounting.receipt.view', $receipt->receipt_voucher_id) . '" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>';
                    $act .= '&nbsp;<a href="#" class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></a>';
                    return $act;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.accounting.receipt.index', compact('clients'));
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
                
        $customers = Customer::select('customer_id', 'customer_name')->orderBy('customer_name')->get();
        

        return view('admin.accounting.receipt.create', compact('customers', 'accountFrom', 'accountTo', 'banks', 'tranTypes', 'analytical', 'voucherTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_date' => 'required|date',
            'ref_date' => 'nullable|date',
            'customer_id' => 'nullable|exists:cs_customer,customer_id',
            'transaction_type' => 'required|string',
            'from_account_code' => 'required|array',
            'from_account_code.*' => 'required|string|max:30',
            'to_account_code' => 'required|array',
            'to_account_code.*' => 'required|string|max:30',
            'analytical_code' => 'nullable|array',
            'analytical_code.*' => 'nullable|string|max:250',
            'bank_master_id.*' => 'nullable|integer',
            'customer_bank.*' => 'nullable|string|max:250',
            'narration.*' => 'nullable|string|max:250',
            'requested_amount' => 'required|numeric|min:0',
            'ref_no' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();

        try {
            $receipt = new ReceiptVoucher();
        
            $receipt->doc_date = $request->doc_date;
            $receipt->doc_date_time = Carbon::now();

            $receipt->reference_no = $request->ref_no;
            $receipt->reference_date = $request->ref_date;

            $receipt->voucher_type = $request->voucher_type;
            $receipt->transaction_type = $request->transaction_type;
            $receipt->receipt_type = $request->boolean('is_advance') ? 'advance' : 'full';
            $receipt->is_advance = $request->boolean('is_advance');
            $receipt->purpose_id = $request->purpose_id;
            $receipt->status = $request->status;
            $receipt->customer_id = $request->customer_id;
            $receipt->remarks = $request->remarks;

            $receipt->to_account_code = $request->to_account_code[0] ?? null;
            $receipt->customer_bank = $request->customer_bank[0] ?? null;
            $receipt->to_analytical_code = $request->analytical_code[0] ?? null;
            $narration_to = $request->narration[0] ?? null;

            $receipt->from_account_code = $request->from_account_code[0] ?? null;
            $receipt->bank_master_id = $request->bank_master_id[0] ?? null;
            $receipt->from_analytical_code = $request->analytical_code[1] ?? null;
            $narration_from = $request->narration[1] ?? null;

            if ($request->status === 'created') {
                $receipt->requested_amount = $request->requested_amount;
            } elseif ($request->status === 'approved') {
                $receipt->approved_amount = $request->approved_amount;
                $receipt->approved_date = date('Y-m-d');
            } elseif ($request->status === 'paid') {
                $receipt->paid_amount = $request->paid_amount;
                $receipt->paid_date = date('Y-m-d');
            } elseif ($request->status === 'settled') {
                $receipt->settled_amount = $request->settled_amount;
            }

            $receipt->save();

            DB::commit();
            return redirect()->route('admin.accounting.receipt.index')->with('success', 'Receipt Voucher created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to submit Receipt Voucher',
                'details' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receipt = ReceiptVoucher::with(['payee', 'bankMaster', 'fromAccount', 'toAccount', 'statusUpdates.creator', 'settlements'])->findOrFail($id);
        $accountTo = [];

        if($receipt->is_advance) {
            $accountTo = ChartOfAccount::query()
                ->selectRaw("account_code as value, CONCAT(account_name, ' - ', account_code) as label")
                ->where('company_id', $receipt->company_id)
                ->where('active', 1)
                ->whereIn('level_1_id', [3, 7])
                ->orderBy('account_code')
                ->get();
        } 

        $analyticals = Analytical::select('analytical_code')
                        ->where('company_id', auth()->user()->company_id)
                        ->where('active', 1)
                        ->get();

        $receiptAmounts = [
            'requested' => $receipt->requested_amount,
            'approved' => $receipt->approved_amount,
            'paid'     => $receipt->paid_amount,
            'settled'  => $receipt->settled_amount,
        ];

        return view('admin.accounting.receipt.view', compact('receipt', 'receiptAmounts', 'accountTo', 'analyticals'));
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
            $receipt = ReceiptVoucher::with('settlements')->findOrFail($id);
            $receipt->status = 'cancelled';
            $receipt->save();

            $receipt->settlements->each(function ($settlement) {
                $settlement->status = 'cancelled';
                $settlement->save();
            });

            DB::commit();
            return response()->json(['message' => 'Receipt Voucher cancelled successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to cancel Receipt Voucher.',
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

        $receipt = ReceiptVoucher::findOrFail($id);

        if ($total > $receipt->requested_amount) {
            return back()->withErrors(['settlement' => 'Total settlement amount exceeds the requested amount.'])->withInput();
        }

        DB::beginTransaction();

        try {

            $settle_post = [];
            foreach ($ledgerAccounts as $index => $accountCode) {
                $amount = ($amounts_debit[$index]>0? $amounts_debit[$index] : $amounts_credit[$index]*-1);
                $tran_type = ($amount>0? 'DR' : 'CR');

                ReceiptSettlement::create([
                    'company_id' => $receipt->company_id,
                    'branch_id' => $receipt->branch_id,
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

            $receipt->stampUserByStatus();
        
            $receipt->status = 'settled';
            $receipt->settled_amount = $total;
            $receipt->save();

            // Posting
            LedgerService::post([
                'company_id' => $receipt->company_id,
                'branch_id' => $receipt->branch_id,
                'doc_type' => $receipt->doc_type,
                'doc_no' => $receipt->doc_no,
                'doc_date' => $receipt->doc_date,
                'doc_date_time' => $receipt->doc_date_time,
                'tran_date' => $settleDate,
            ], $settle_post);

            DB::commit();
            return redirect()->back()->with('success', 'Receipt settled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to submit Receipt Settlement',
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

    public function changeStatus(Request $request)
    {
        $receipt_id = $request->input('receipt_id');
        $status = $request->input('status');

        $receipt = ReceiptVoucher::findOrFail($receipt_id);
        $receipt->status = $status;
        
        if ($status === 'created') {
            $receipt->requested_amount = $receipt->requested_amount;
        } elseif ($status === 'approved') {
            $receipt->approved_amount = $receipt->requested_amount;
        } elseif ($status === 'paid') {
            $receipt->paid_amount = $receipt->requested_amount;
            $receipt->paid_date = date('Y-m-d');
        } elseif ($status === 'settled') {
            $receipt->settled_amount = $receipt->requested_amount;
        }
        $receipt->save();

        if($status === 'paid') {
            LedgerService::post([
                'company_id' => $receipt->company_id,
                'branch_id' => $receipt->branch_id,
                'doc_type' => $receipt->doc_type,
                'doc_no' => $receipt->doc_no,
                'doc_date' => $receipt->doc_date,
                'doc_date_time' => $receipt->doc_date_time,
                'tran_date' => $receipt->paid_date,
            ], [
                [
                    'account_code' => $receipt->to_account_code,
                    'tran_type' => 'DR',
                    'other_type' => ($receipt->customer_id == 1? 'analytical' : 'customer'),
                    'record_id' => ($receipt->customer_id == 1? $receipt->to_analytical_code : $receipt->customer_id),
                    'amount' => $receipt->requested_amount,
                    'analytical_code' => $receipt->to_analytical_code,
                    'narration' => $receipt->to_narration,
                ],
                [
                    'account_code' => $receipt->from_account_code,
                    'tran_type' => 'CR',
                    'other_type' => ($receipt->customer_id == 1? 'analytical' : 'customer'),
                    'record_id' => ($receipt->customer_id == 1? $receipt->from_analytical_code : $receipt->customer_id),
                    'amount' => $receipt->requested_amount*-1,
                    'analytical_code' => $receipt->from_analytical_code,
                    'narration' => $receipt->from_narration,
                ]
            ]);
        }

        $receipt->stampUserByStatus();
        
        echo true;
    }

    public function print($id)
    {
        $receipt = ReceiptVoucher::findOrFail($id);

        return view('admin.accounting.receipt.print', compact('receipt'));
    }
}

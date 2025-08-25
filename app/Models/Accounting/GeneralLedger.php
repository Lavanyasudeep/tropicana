<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Purchase\Supplier;
use App\Models\Master\Accounting\ChartOfAccount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class GeneralLedger extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_general_ledger';
    protected $primaryKey = 'gl_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($payment) {
            $year = Carbon::now()->format('y');

            // Count existing records for the current year
            $countYear = self::whereYear('created_at', $year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $payment->company_id = auth()->user()->company_id ?? 1;
            $payment->branch_id = auth()->user()->branch_id ?? 1;
            $payment->department_id = auth()->user()->department_id ?? 1;

            // Safely set doc_type and doc_no if not already set
            $payment->doc_type = $payment->doc_type ?? "ledger";
            $payment->doc_no = $payment->doc_no ?? "GL-{$year}-{$sequence}";
        });
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'tran_type', 'transaction_type');
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_code', 'account_code');
    }

}

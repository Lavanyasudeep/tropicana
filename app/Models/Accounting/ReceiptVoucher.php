<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\Common\StatusUpdate;
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Purchase\Customer;
use App\Models\Master\Accounting\BankMaster;

use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\ReceiptSettlement;

use App\Models\Traits\TracksStatusChanges;

use App\Enums\VoucherType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class ReceiptVoucher extends BaseModel
{
    use HasFactory, TracksStatusChanges;

    protected $table = 'cs_receipt_voucher';
    protected $primaryKey = 'receipt_voucher_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected $casts = [
        'voucher_type' => VoucherType::class,
    ];

    protected $appends = ['voucher_type_label'];
    protected $statusOldForLogging;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($receipt) {
            $year = Carbon::now()->format('y');

            // Count existing records for the current year
            $countYear = self::whereYear('created_at', $year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $receipt->company_id = auth()->user()->company_id ?? 1;
            $receipt->branch_id = auth()->user()->branch_id ?? 1;
            $receipt->department_id = auth()->user()->department_id ?? 1;

            // Safely set doc_type and doc_no if not already set
            $receipt->doc_type = $receipt->doc_type ?? "receipt";
            $receipt->doc_no = $receipt->doc_no ?? "PY-{$year}-{$sequence}";
        });
    }
    
    public function payee()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type', 'transaction_type');
    }

    public function fromAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'from_account_code', 'account_code');
    }

    public function toAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'to_account_code', 'account_code');
    }

    public function bankMaster()
    {
        return $this->belongsTo(BankMaster::class, 'bank_master_id', 'bank_master_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function settledBy()
    {
        return $this->belongsTo(User::class, 'settled_by', 'id');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by', 'id');
    }

    public function getVoucherTypeLabelAttribute(): string
    {
        return $this->voucher_type?->label() ?? '';
    }

    public function stampUserByStatus()
    {
        $userId = Auth::id() ?? null;
        if (!$userId || !$this->status) {
            return;
        }
       
        switch ($this->status) {
            case 'created':
                $this->forceFill([
                    'status'    => 'requested',
                    'requested_by' => $userId,
                    'requested_date' => now(),
                ])->save();
                break;

            case 'approved':
                $this->forceFill([
                    'approved_by' => $userId,
                    'approved_date' => now(),
                ]);
                break;

            case 'paid':
                $this->forceFill([
                    'paid_by' => $userId,
                    'paid_date' => now(),
                ]);
                break;

            case 'settled':
                $this->forceFill([
                    'settled_by' => $userId,
                    'settled_date' => now(),
                ]);
                break;
        }

        $this->save();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }
    
    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'receipt_voucher_id')
            ->where('table_name', $this->getTable());
    }

    public function settlements()
    {
        return $this->hasMany(ReceiptSettlement::class, 'voucher_id', 'receipt_voucher_id');
    }

}

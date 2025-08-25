<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use App\Models\User; 

use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\PaymentVoucher;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class PaymentSettlement extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_payment_settlement';
    protected $primaryKey = 'settlement_id';
    protected $guarded = []; 

    public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_code', 'account_code');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'voucher_id', 'payment_voucher_id');
    }

}

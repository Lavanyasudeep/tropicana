<?php

namespace App\Models\Master\Accounting;

use App\Models\{ BaseModel, Company};
use App\Models\User;

use App\Models\Master\Accounting\ChartOfAccount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class PaymentPurpose extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_payment_purpose';
    protected $primaryKey = 'purpose_id';
    protected $guarded = []; 

    public $timestamps = true;

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function bSheetAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'bsheet_account_code', 'account_code');
    }

    public function expAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'exp_account_code', 'account_code');
    }

}

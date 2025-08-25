<?php

namespace App\Models\Master\Accounting;

use App\Models\Master\Accounting\ChartOfAccount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankMaster extends Model
{
    use HasFactory;

    protected $table = 'cs_bank_master';
    protected $primaryKey = 'bank_master_id';
    protected $guarded = [];

    public function chartOfAccount()
    {
        return $this->hasOne(ChartOfAccount::class, 'account_code', 'account_code');
    }

}
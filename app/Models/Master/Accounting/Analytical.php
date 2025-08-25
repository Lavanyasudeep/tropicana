<?php

namespace App\Models\Master\Accounting;

use App\Models\{BaseModel, Company, User};
use App\Models\Master\Accounting\{ChartOfAccount};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analytical extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_analytical';
    protected $primaryKey = 'analytical_id';
    protected $guarded = [];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function chartOfAccount() {
        return $this->belongsTo(ChartOfAccount::class, 'account_code', 'account_code');
    }
}
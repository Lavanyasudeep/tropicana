<?php

namespace App\Models\Master\Accounting;

use App\Models\BaseModel;

use App\Models\Master\Accounting\{ Level1, Level2};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class ChartOfAccount extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_chart_of_account';
    protected $primaryKey = 'account_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($account) {
            $account->company_id = auth()->user()->company_id ?? 1;
        });

    }

    public function level1() {
        return $this->belongsTo(Level1::class, 'level_1_id', 'level_1_id');
    }
    
    public function level2() {
        return $this->belongsTo(Level2::class, 'level_2_id', 'level_2_id');
    }
}

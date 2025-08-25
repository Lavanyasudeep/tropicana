<?php

namespace App\Models\Master\Accounting;

use App\Models\BaseModel;

use App\Models\Master\Accounting\{ Level1, ChartOfAccount};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class Level2 extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_level_2';
    protected $primaryKey = 'level_2_id';
    protected $guarded = []; 

    public $timestamps = true;

    public function accounts() {
        return $this->hasMany(ChartOfAccount::class, 'level_2_id');
    }
}

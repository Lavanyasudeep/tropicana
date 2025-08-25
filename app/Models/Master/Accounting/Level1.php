<?php

namespace App\Models\Master\Accounting;

use App\Models\BaseModel;

use App\Models\Master\Accounting\{ Level2};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class Level1 extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_level_1';
    protected $primaryKey = 'level_1_id';
    protected $guarded = []; 

    public $timestamps = true;

    public function level2s() {
        return $this->hasMany(Level2::class, 'level_1_id', 'level_1_id');
    }
}

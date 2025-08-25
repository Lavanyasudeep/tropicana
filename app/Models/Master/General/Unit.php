<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'cs_unit';
    protected $primaryKey = 'unit_id';
    protected $guarded = []; 

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

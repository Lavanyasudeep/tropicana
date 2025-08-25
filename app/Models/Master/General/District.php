<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    
    protected $table = 'cs_district';
    protected $primaryKey = 'district_id';
    protected $guarded = [];
}

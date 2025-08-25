<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'cs_brand';
    protected $primaryKey = 'brand_id';
    protected $guarded = [];
}
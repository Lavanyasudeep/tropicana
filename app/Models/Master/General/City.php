<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table = 'cs_city';
    protected $primaryKey = 'city_id';
    protected $guarded = [];
}

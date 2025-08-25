<?php

namespace App\Models\Master\General;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_tax';
    protected $primaryKey = 'tax_id';
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
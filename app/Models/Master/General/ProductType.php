<?php

namespace App\Models\Master\General;

use App\Models\BaseModel;

use App\Models\Master\General\ProductTypePrice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductType extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_product_types';
    protected $primaryKey = 'product_type_id';
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function prices()
    {
        return $this->hasMany(ProductTypePrice::class, 'product_type_id', 'product_type_id');
    }

    public function isActive()
    {
        return $this->active? 1:0;
    }

}
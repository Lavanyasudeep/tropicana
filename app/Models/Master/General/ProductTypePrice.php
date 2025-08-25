<?php

namespace App\Models\Master\General;

use App\Models\BaseModel;

use App\Models\Master\General\{ ProductType, Unit};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTypePrice extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_product_type_price';
    protected $primaryKey = 'price_id';
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'product_type_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id'); 
    }

    public function isActive()
    {
        return $this->active? 1:0;
    }
}
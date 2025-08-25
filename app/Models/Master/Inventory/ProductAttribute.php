<?php

namespace App\Models\Master\Inventory;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_product_attributes';
    protected $primaryKey = 'product_attribute_id';
    protected $guarded = []; 
    public $timestamps = true;
    
}

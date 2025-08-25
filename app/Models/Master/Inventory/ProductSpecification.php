<?php

namespace App\Models\Master\Inventory;

use App\Models\BaseModel;
use App\Models\Master\Inventory\{ProductAttribute};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSpecification extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_product_specifications';
    protected $primaryKey = 'prod_spec_id';
    protected $guarded = []; 
    public $timestamps = true;
    
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'prod_attribute_id', 'product_attribute_id');
    }

}

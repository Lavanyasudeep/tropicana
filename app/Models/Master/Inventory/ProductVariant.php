<?php

namespace App\Models\Master\Inventory;

use App\Models\BaseModel;
use App\Models\Master\Inventory\{ProductVariantSpecification};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_product_variants';
    protected $primaryKey = 'product_variant_id';
    protected $guarded = []; 
    public $timestamps = true;
    
    public function productSpecifications()
    {
        return $this->hasMany(ProductVariantSpecification::class, 'product_variant_id', 'product_variant_id');
    }

}

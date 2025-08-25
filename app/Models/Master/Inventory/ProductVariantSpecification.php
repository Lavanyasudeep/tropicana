<?php

namespace App\Models\Master\Inventory;

use App\Models\BaseModel;
use App\Models\Master\Inventory\{ProductSpecification};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariantSpecification extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_product_variant_specifications';
    protected $primaryKey = 'prod_variant_spec_id';
    protected $guarded = []; 
    public $timestamps = true;
    
    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class, 'prod_spec_id', 'prod_spec_id');
    }

}

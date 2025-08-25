<?php

namespace App\Models\Master\Inventory;

use Illuminate\Database\Eloquent\Model;

class ProdCatSvgImg extends Model
{
    protected $table = 'cs_prod_cat_svg_img';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'product_category_id');
    }
}

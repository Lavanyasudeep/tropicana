<?php

namespace App\Models\Master\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'cs_product_category';
    protected $primaryKey = 'product_category_id';
    protected $guarded = []; 
}

<?php

namespace App\Models\Master\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'cs_product';
    protected $primaryKey = 'product_ids';
    protected $guarded = []; 
    public $timestamps = false;

    public function productMasters()
    {
        return $this->hasMany(ProductMaster::class, 'product_id', 'product_id');
    }
    
}

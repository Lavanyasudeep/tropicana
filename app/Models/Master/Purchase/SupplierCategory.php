<?php

namespace App\Models\Master\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierCategory extends Model
{
    use HasFactory;

    protected $table = 'cs_supplier_category';
    protected $primaryKey = 'supplier_category_id';
    protected $guarded = [];
}

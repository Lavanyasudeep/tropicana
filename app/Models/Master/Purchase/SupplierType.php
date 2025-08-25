<?php

namespace App\Models\Master\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierType extends Model
{
    use HasFactory;

    protected $table = 'cs_supplier_type';
    protected $primaryKey = 'supplier_type_id';
    protected $guarded = [];
}

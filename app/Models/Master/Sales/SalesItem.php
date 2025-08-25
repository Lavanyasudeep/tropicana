<?php

namespace App\Models\Master\Sales;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesItem extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_sales_item';
    protected $primaryKey = 'sales_item_id';
    protected $guarded = []; 
    public $timestamps = true;
    
}

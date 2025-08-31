<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Master\Sales\{Customer, SalesItem};
use App\Models\Master\General\{Unit, Tax, ProductType};
use App\Models\Sales\{SalesInvoice};
use App\Models\{Company, Client};
use App\Models\Master\General\Status;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesInvoiceDetail extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_sales_invoice_details';
    protected $primaryKey = 'sales_invoice_detail_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

    }

    public function invoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'sq_id', 'sq_id');
    }

    public function product()
    {
        return $this->belongsTo(SalesItem::class, 'sales_item_id', 'sales_item_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'product_type_id');
    }

    public function salesItem()
    {
        return $this->belongsTo(salesItem::class, 'sales_item_id', 'sales_item_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_per', 'tax_per');
    }

    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'inward_detail_id')
            ->where('table_name', $this->getTable());
    }

}

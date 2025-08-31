<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Common\StatusUpdate;
use App\Models\Master\Sales\{ Customer, SalesItem};
use App\Models\Sales\{ SalesInvoiceDetail};
use App\Models\{Company, Client};
use App\Models\Master\General\Status;

use App\Models\Traits\TracksStatusChanges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class SalesInvoice extends BaseModel
{
    use HasFactory, TracksStatusChanges;

    protected $table = 'cs_sales_invoice';
    protected $primaryKey = 'sales_invoice_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($customerEnquiry) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $customerEnquiry->company_id = auth()->user()->company_id ?? 1;
            $customerEnquiry->branch_id = auth()->user()->branch_id ?? 1;

            $customerEnquiry->doc_type = $customerEnquiry->doc_type ?? "sales-invoice";
            $customerEnquiry->doc_no = $customerEnquiry->doc_no ?? "SQ-{$year}-{$sequence}";
        });

    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(SalesInvoiceDetail::class, 'sales_invoice_id', 'sales_invoice_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'sales_invoice_id')
            ->where('table_name', $this->getTable());
    }
    
}

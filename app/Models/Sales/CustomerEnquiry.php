<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Common\StatusUpdate;
use App\Models\Master\Sales\Customer;

use App\Models\Traits\TracksStatusChanges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class CustomerEnquiry extends BaseModel
{
    use HasFactory, TracksStatusChanges;

    protected $table = 'cs_customer_enquiry';
    protected $primaryKey = 'customer_enquiry_id';
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

            $customerEnquiry->doc_type = $customerEnquiry->doc_type ?? "customer-enquiry";
            $customerEnquiry->doc_no = $customerEnquiry->doc_no ?? "CE-{$year}-{$sequence}";
        });

    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'customer_enquiry_id')
            ->where('table_name', $this->getTable());
    }
    
}

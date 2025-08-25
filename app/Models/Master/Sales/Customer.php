<?php

namespace App\Models\Master\Sales;

use App\Models\{ BaseModel, branch};
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_customer';
    protected $primaryKey = 'customer_id';
    protected $guarded = [];

    protected $appends = ['customer_address'];

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($customer) {
            $customer->company_id = auth()->user()->company_id ?? 1;
            $customer->branch_id = auth()->user()->branch_id ?? 1;
        });

    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'place_id');
    }

    public function postoffice()
    {
        return $this->belongsTo(PostOffice::class, 'post_office_id', 'post_office_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function shippingCity()
    {
        return $this->belongsTo(City::class, 'shipping_city_id', 'city_id');
    }

    public function shippingDistrict()
    {
        return $this->belongsTo(District::class, 'shipping_district_id', 'district_id');
    }

    public function shippingState()
    {
        return $this->belongsTo(State::class, 'shipping_state_id', 'state_id');
    }

     public function billingCity()
    {
        return $this->belongsTo(City::class, 'billing_city_id', 'city_id');
    }

    public function billingDistrict()
    {
        return $this->belongsTo(District::class, 'billing_district_id', 'district_id');
    }

    public function billingState()
    {
        return $this->belongsTo(State::class, 'billing_state_id', 'state_id');
    }

    public function getCustomerAddressAttribute()
    {
        $addressParts = array_filter([
            $this->MainAddress1,
            $this->MainAddress2,
            optional($this->place)->PlaceName,
            ($this->postoffice ? ($this->postoffice->post_office . '-' . $this->postoffice->pincode) : null),
            optional($this->city)->city_name,
            optional($this->district)->district_name,
            optional($this->state)->state_name,
        ]);
    
        return implode(', ', $addressParts);
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo 
            ? asset('storage/' . $this->photo)
            : asset('images/default-avatar.jpg');
    }
}

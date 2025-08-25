<?php

namespace App\Models;

use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit, Country};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $table = 'cs_company';
    protected $primaryKey = 'company_id';
    protected $guarded = []; 

    public $timestamps = false;
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
    
    public function postoffice()
    {
        return $this->belongsTo(PostOffice::class, 'post_office_id', 'post_office_id');
    }
}

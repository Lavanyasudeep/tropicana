<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit, Country};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'cs_branch';
    protected $primaryKey = 'branch_id';
    protected $guarded = []; 

    public $timestamps = false;
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
}

<?php

namespace App\Models\Master\HR;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_designation';
    protected $primaryKey = 'designation_id';
    protected $guarded = [];

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($designation) {
            $designation->company_id = auth()->user()->company_id ?? 1;
        });

    }
    
}

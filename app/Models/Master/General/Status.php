<?php

namespace App\Models\Master\General;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_status';
    protected $primaryKey = 'status_id';
    protected $guarded = []; 

    public $timestamps = true;

}

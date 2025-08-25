<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Port extends Model
{
    use HasFactory;

    protected $table = 'cs_port';
    protected $primaryKey = 'port_id';
    protected $guarded = [];
}

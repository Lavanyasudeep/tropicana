<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $table = 'cs_state';
    protected $primaryKey = 'state_id';
    protected $guarded = [];
}

<?php

namespace App\Models\Master\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostOffice extends Model
{
    use HasFactory;

    protected $table = 'cs_post_office';
    protected $primaryKey = 'post_office_id';
    protected $guarded = [];
}

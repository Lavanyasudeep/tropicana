<?php

namespace App\Models\Common;

use App\Models\BaseModel;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusUpdate extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_status_updates';
    protected $primaryKey = 'status_update_id';
    protected $guarded = []; 

    public $timestamps = true;

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function target()
    {
        return $this->morphTo(__FUNCTION__, 'table_name', 'row_id');
    }

}

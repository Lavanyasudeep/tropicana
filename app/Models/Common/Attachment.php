<?php

namespace App\Models\Common;

use App\Models\BaseModel;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_attachments';
    protected $primaryKey = 'attachment_id';
    protected $guarded = []; 

    public $timestamps = true;

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

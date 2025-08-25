<?php

namespace App\Models;

use App\Models\Branch;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'cs_department';
    protected $primaryKey = 'department_id';
    protected $guarded = []; 

    public $timestamps = false;
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }
}

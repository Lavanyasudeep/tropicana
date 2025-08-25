<?php

namespace App\Models\Master\HR;

use App\Models\BaseModel;
use App\Models\Master\HR\{Designation};
use App\Models\{ Company, Branch, Department};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Employee extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_employee';
    protected $primaryKey = 'employee_id';
    protected $guarded = [];

    protected $appends = ['employee_name', 'photo_url'];

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($employee) {
            $employee->company_id = auth()->user()->company_id ?? 1;

            $lastPayroll = DB::table('cs_employee')
                    ->orderBy('employee_id', 'desc')
                    ->value('payroll_number');

            if ($lastPayroll) {
                $num = (int) filter_var($lastPayroll, FILTER_SANITIZE_NUMBER_INT);
                $employee->payroll_number = 'EMP' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $employee->payroll_number = 'EMP0001';
            }
        });

    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'designation_id');
    }

    public function getEmployeeNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo 
            ? asset('storage/' . $this->photo)
            : asset('images/default-avatar.jpg');
    }
}

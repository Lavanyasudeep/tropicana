<?php

namespace App\Models\Accounting;

use App\Models\{ BaseModel, Branch, Department};
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Purchase\Supplier;
use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\JournalDetail;

use App\Models\Traits\TracksStatusChanges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class Journal extends BaseModel
{
    use HasFactory, TracksStatusChanges;

    protected $table = 'cs_journal';
    protected $primaryKey = 'journal_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($payment) {
            $year = Carbon::now()->format('y');

            // Count existing records for the current year
            $countYear = self::whereYear('created_at', $year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $payment->company_id = auth()->user()->company_id ?? 1;

            // Safely set doc_type and doc_no if not already set
            $payment->doc_type = $payment->doc_type ?? "journal";
            $payment->doc_no = $payment->doc_no ?? "JV-{$year}-{$sequence}";
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function journalDetails()
    {
        return $this->hasMany(JournalDetail::class, 'journal_id', 'journal_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }
    
    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'journal_id')
            ->where('table_name', $this->getTable());
    }
}

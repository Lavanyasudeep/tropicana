<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use App\Models\Master\Accounting\TransactionType;
use App\Models\Master\Purchase\Supplier;
use App\Models\Master\Accounting\ChartOfAccount;
use App\Models\Accounting\Journal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class JournalDetail extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_journal_detail';
    protected $primaryKey = 'journal_detail_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id', 'journal_id');
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_code', 'account_code');
    }

}

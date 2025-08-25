<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use App\Models\Common\StatusUpdate;
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{Inward, InwardDetail, Outward, OutwardDetail, PackingList, PackingListDetail, PickList, PickListDetail, Stock, StockAdjustment};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};

use App\Enums\MovementType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class PickList extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_picklist';
    protected $primaryKey = 'picklist_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();
        
        // static::creating(function ($pickList) {
        //     $today = Carbon::now()->format('Ymd');
        //     $countToday = self::whereDate('created_at', Carbon::today())->count();
        //     $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        //     $pickList->doc_no = $pickList->doc_no ?? "PIC-{$today}-{$sequence}";
        //     $pickList->status = Status::Created;
        // });

        static::creating(function ($pickList) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $pickList->company_id = auth()->user()->company_id ?? 1;
            $pickList->branch_id = auth()->user()->branch_id ?? 1;

            $pickList->doc_type = $pickList->doc_type ?? "picklist";
            $pickList->doc_no = $pickList->doc_no ?? "PIC-{$year}-{$sequence}";
        });

    }
    
    public function pickListDetails()
    {
        return $this->hasMany(PickListDetail::class, 'picklist_id', 'picklist_id');
    }

    public function details()
    {
        return $this->hasMany(PickListDetail::class, 'picklist_id', 'picklist_id');
    }

    public function cancelledPickListDetails()
    {
        return $this->hasMany(PickListDetail::class, 'picklist_id', 'picklist_id')->withTrashed();
    }

    public function outward()
    {
        return $this->hasOne(Outward::class, 'picklist_id', 'picklist_id');
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    // public function getDocDateAttribute()
    // {
    //     return $this->formatDate('doc_date');
    // }

    public function getStatusListAttribute()
    {
        return $this->pickListDetails
            ->pluck('status')
            ->filter()
            ->map(fn($status) => ucfirst($status))
            ->unique()
            ->values();
    }

    public function getStatusAttribute()
    {
        return $this->status_list
            ->map(fn($s) => ucfirst($s))
            ->implode(', ');
    }
}

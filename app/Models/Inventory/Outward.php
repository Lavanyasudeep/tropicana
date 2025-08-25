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

use App\Services\Inventory\StockService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class Outward extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_outward';
    protected $primaryKey = 'outward_id';
    protected $guarded = []; 

    public $timestamps = true;
    
    protected $appends = ['packing_lists'];

    protected static function booted()
    {
        parent::booted();
        
        // static::creating(function ($outward) {
        //     $today = Carbon::now()->format('Ymd');
        //     $countToday = self::whereDate('created_at', Carbon::today())->count();
        //     $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        //     $outward->doc_no = $outward->doc_no ?? "OW-{$today}-{$sequence}";
        //     $outward->status = Status::Created;
        // });

        static::creating(function ($outward) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $outward->company_id = auth()->user()->company_id ?? 1;
            $outward->branch_id = auth()->user()->branch_id ?? 1;

            $outward->doc_type = $outward->doc_type ?? "outward";
            $outward->doc_no = $outward->doc_no ?? "OW-{$year}-{$sequence}";
        });
    }
    
    public function outwardDetails()
    {
        return $this->hasMany(OutwardDetail::class, 'outward_id', 'outward_id');
    }

    public function details()
    {
        return $this->hasMany(OutwardDetail::class, 'outward_id', 'outward_id');
    }

    public function pickList()
    {
        return $this->belongsTo(PickList::class, 'picklist_id', 'picklist_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function getPackingListsAttribute()
    {
        return $this->outwardDetails
            ->map(function ($detail) {
                return optional($detail->pickListDetail?->packingListDetail?->packingList);
            })
            ->filter()
            ->unique('packing_list_id')
            ->values();
    }

    public function getStatusListAttribute()
    {
        return $this->outwardDetails
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

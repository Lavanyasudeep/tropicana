<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{Inward, InwardDetail, Outward, OutwardDetail, PackingList, PackingListDetail, PickList, PickListDetail, Stock, StockAdjustment};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class Inward extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_inward';
    protected $primaryKey = 'inward_id';
    protected $guarded = []; 
    
    protected $appends = ['product_variants'];

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();
        
        // static::creating(function ($inward) {
        //     $today = Carbon::now()->format('Ymd');
        //     $countToday = self::whereDate('created_at', Carbon::today())->count();
        //     $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        //     $inward->doc_no = $inward->doc_no ?? "IW-{$today}-{$sequence}";
        //     $inward->status = Status::Created;
        // });

        static::creating(function ($inward) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $inward->company_id = auth()->user()->company_id ?? 1;
            $inward->branch_id = auth()->user()->branch_id ?? 1;

            $inward->doc_type = $inward->doc_type ?? "inward";
            $inward->doc_no = $inward->doc_no ?? "IW-{$year}-{$sequence}";
        });

    }
    
    public function packingList()
    {
        return $this->belongsTo(PackingList::class, 'packing_list_id', 'packing_list_id');
    }

    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function inwardDetails()
    {
        return $this->hasMany(InwardDetail::class, 'inward_id', 'inward_id');
    }

    public function details()
    {
        return $this->hasMany(InwardDetail::class, 'inward_id', 'inward_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }
    
    public function getStatusListAttribute()
    {
        return $this->inwardDetails
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

    public function getProductVariantsAttribute()
    {
        return $this->inwardDetails
            ->pluck('packingListDetail.grnDetail.productVariant')
            ->filter() // remove nulls
            ->unique('product_variant_id') // use correct PK field
            ->values(); // re-index
    }
}

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

use App\Enums\MovementType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class PackingList extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_packing_list';
    protected $primaryKey = 'packing_list_id';
    protected $guarded = [];

    protected $appends = ['goods', 'container_nos', 'size', 'package_types'];

    public $timestamps = true;
    
    protected $casts = [
        'movement_type' => MovementType::class
    ];

    protected static function booted()
    {
        parent::booted();
        
        // static::creating(function ($packingList) {
        //     $today = Carbon::now()->format('Ymd');
        //     $countToday = self::whereDate('created_at', Carbon::today())->count();
        //     $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        //     $packingList->doc_no = $packingList->doc_no ?? "PKG-{$today}-{$sequence}";
        //     $packingList->status = Status::Created;
        // });

        static::creating(function ($packingList) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $packingList->company_id = auth()->user()->company_id ?? 1;
            $packingList->branch_id = auth()->user()->branch_id ?? 1;

            $packingList->doc_type = $packingList->doc_type ?? "packinglist";
            $packingList->doc_no = $packingList->doc_no ?? "PKG-{$year}-{$sequence}";
            $packingList->status = 'created';
        });

    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function packingListDetails()
    {
        return $this->hasMany(PackingListDetail::class, 'packing_list_id', 'packing_list_id');
    }

    public function grn()
    {
        return $this->belongsTo(GRN::class, 'grn_id', 'GRNBatchID');
    }

    public function packageType()
    {
        return $this->belongsTo(Unit::class, 'package_type_id', 'unit_id');
    }

    public function getGoodsAttribute()
    {
        return $this->packingListDetails()
            ->pluck('cargo_description')
            ->unique()
            ->filter()
            ->implode(', ');
    }

    public function getContainerNosAttribute()
    {
        return $this->packingListDetails()
            ->pluck('container_no')
            ->filter()
            ->implode('-');
    }

    public function getSizeAttribute()
    {
        return $this->packingListDetails()
            ->pluck('item_size_per_package')
            ->filter()
            ->implode('x');
    }

    public function getPackageTypesAttribute()
    {
        return $this->packingListDetails()
                    ->get() 
                    ->map(function ($detail) {
                        return optional($detail->packageType)->description;
                    })
                    ->filter()
                    ->unique()
                    ->implode(',');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function updateTotalsFromDetails()
    {
        $this->loadMissing('packingListDetails');

        $this->tot_package = $this->packingListDetails->sum('package_qty');
        $this->tot_pallet_qty  = $this->packingListDetails->sum('pallet_qty');
        $this->total_gw_kg    = $this->packingListDetails->sum('gw_with_pallet');
        $this->total_nw_kg    = $this->packingListDetails->sum('nw_kg');

        return $this->save();
    }

}

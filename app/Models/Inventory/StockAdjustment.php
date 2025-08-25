<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use App\Models\Common\StatusUpdate;
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{PackingList, PackingListDetail, Stock, StockAdjustmentDetail};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};

use App\Enums\StockAdjustmentReason;

use App\Models\Traits\TracksStatusChanges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

class StockAdjustment extends BaseModel
{
    use HasFactory, TracksStatusChanges;

    protected $table = 'cs_stock_adjustment';
    protected $primaryKey = 'stock_adjustment_id';
    protected $guarded = [];

    protected $appends = ['goods', 'package_types', 'tot_package', 'tot_pallet_qty', 'total_gw_kg', 'total_nw_kg'];

    public $timestamps = true;
    
    protected $casts = [
        'stockAdjustmentReason' => StockAdjustmentReason::class
    ];

    protected static function booted()
    {
        parent::booted();
        
        // static::creating(function ($stockAdj) {
        //     $today = Carbon::now()->format('Ymd');
        //     $countToday = self::whereDate('created_at', Carbon::today())->count();
        //     $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        //     $stockAdj->company_id = auth()->user()->company_id ?? 1;
        //     $stockAdj->branch_id = auth()->user()->branch_id ?? 1;
        //     $stockAdj->doc_no = $stockAdj->doc_no ?? "SAJ-{$today}-{$sequence}";
        //     $stockAdj->status = Status::Created;
        // });

        static::creating(function ($stockAdj) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $stockAdj->company_id = auth()->user()->company_id ?? 1;
            $stockAdj->branch_id = auth()->user()->branch_id ?? 1;

            $stockAdj->doc_type = $stockAdj->doc_type ?? "ADJ";
            $stockAdj->doc_no = $stockAdj->doc_no ?? "PIC-{$year}-{$sequence}";
            $stockAdj->status = 'created';
        });

    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function stockAdjustmentDetails()
    {
        return $this->hasMany(stockAdjustmentDetail::class, 'stock_adjustment_id', 'stock_adjustment_id');
    }

    public function getGoodsAttribute()
    {
        return $this->stockAdjustmentDetails()
            ->pluck('product_description')
            ->filter()
            ->implode(', ');
    }

    // public function getContainerNosAttribute()
    // {
    //     return $this->stockAdjustmentDetails()
    //         ->pluck('packingListDetail.container_no')
    //         ->filter()
    //         ->implode('-');
    // }

    // public function getSizeAttribute()
    // {
    //     return $this->stockAdjustmentDetails()
    //         ->pluck('packingListDetail.item_size_per_package')
    //         ->filter()
    //         ->implode('x');
    // }

    public function getPackageTypesAttribute()
    {
        return $this->stockAdjustmentDetails()
                    ->get() 
                    ->map(function ($detail) {
                        return optional($detail->packingListDetail->packageType)->description;
                    })
                    ->filter()
                    ->unique()
                    ->implode(',');
    }

    public function getTotPackageAttribute()
    {
        return $this->stockAdjustmentDetails->sum('quantity');
    }

    public function getTotPalletQtyAttribute()
    {
        return $this->stockAdjustmentDetails->sum('pallet_qty');
    }

    public function getTotalGwKgAttribute()
    {
        return $this->stockAdjustmentDetails->sum(function ($detail) {
            return $detail->gw_with_pallet;
        });
    }

    public function getTotalNwKgAttribute()
    {
        return $this->stockAdjustmentDetails->sum(function ($detail) {
            return $detail->nw_kg;
        });
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'stock_adjustment_id')
            ->where('table_name', $this->getTable());
    }
}

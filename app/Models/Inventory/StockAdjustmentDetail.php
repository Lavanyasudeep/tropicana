<?php

namespace App\Models\Inventory;

use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{PackingList, PackingListDetail, Stock, StockAdjustment};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{BaseModel, Company, Client};

use App\Services\Inventory\StockService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockAdjustmentDetail extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_stock_adjustment_detail';
    protected $primaryKey = 'stock_adjustment_detail_id';
    protected $guarded = [];

    public $timestamps = false;

    protected $appends = ['gw_with_pallet', 'nw_kg'];

    protected static function booted()
    {
        static::created(function ($stockAdjDetail) {
            $stockAdjDetail->load('packingListDetail');
            
            $packingListDetail = $stockAdjDetail->packingListDetail;

            if ($stockAdjDetail->movement_type == 'in') {
                StockService::adjustQuantity($stockAdjDetail, $packingListDetail, $stockAdjDetail->quantity??0);
            } else {
                StockService::adjustQuantity($stockAdjDetail, $packingListDetail, -$stockAdjDetail->quantity??0);
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(ProductMaster::class, 'product_id', 'product_master_id');
    }

    public function stockAdjustment()
    {
        return $this->belongsTo(StockAdjustment::class, 'stock_adjustment_id', 'stock_adjustment_id');
    }

    public function packingList()
    {
        return $this->belongsTo(PackingList::class, 'packing_list_id', 'packing_list_id');
    }

    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function room()
    {
        return $this->belongsTo(StorageRoom::class, 'room_id', 'room_id');
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_id', 'rack_id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id', 'slot_id');
    }

    public function pallet()
    {
        return $this->belongsTo(Pallet::class, 'pallet_id', 'pallet_id');
    }

    public function getGwWithPalletAttribute()
    {
        $detail = $this->packingListDetail;
        $list = $this->packingList;

        $gwPerPackage = optional($detail)->gw_per_package ?? 0;
        $packageQty = optional($detail)->package_qty ?? 0;
        $palletQty = optional($detail)->pallet_qty ?? 0;
        $weightPerPallet = optional($list)->weight_per_pallet ?? 0;

        return ($gwPerPackage * $packageQty) + ($palletQty * $weightPerPallet);
    }

    public function getNwKgAttribute()
    {
        $detail = $this->packingListDetail;

        $nwPerPackage = optional($detail)->nw_per_package ?? 0;
        $packageQty = optional($detail)->package_qty ?? 0;

        return $nwPerPackage * $packageQty;
    }


}

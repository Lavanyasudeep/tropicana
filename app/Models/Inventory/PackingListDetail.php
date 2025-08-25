<?php

namespace App\Models\Inventory;

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

class PackingListDetail extends Model
{
    use HasFactory;

    protected $table = 'cs_packing_list_detail';
    protected $primaryKey = 'packing_list_detail_id';
    protected $guarded = [];

    protected $appends = ['contact_person'];

    public $timestamps = false;

    protected static function booted()
    {

        static::saving(function ($model) {
            $model->calculateWeights();
        });

        static::saved(function ($model) {
            if ($model->packingList) {
                $model->packingList->updateTotalsFromDetails();
            }
        });

        static::deleted(function ($model) {
            if ($model->packingList) {
                $model->packingList->updateTotalsFromDetails();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(ProductMaster::class, 'product_id', 'product_master_id');
    }

    public function packingList()
    {
        return $this->belongsTo(PackingList::class, 'packing_list_id', 'packing_list_id');
    }

    public function grnDetail()
    {
        return $this->belongsTo(GRNDetail::class, 'grn_detail_id', 'GRNProductID');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function inward()
    {
        return $this->hasOne(Inward::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function inwardDetail()
    {
        return $this->hasOne(InwardDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function packageType()
    {
        return $this->belongsTo(Unit::class, 'package_type_id', 'unit_id');
    }

    public function variety()
    {
        return $this->belongsTo(ProductCategory::class, 'variety_id', 'product_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function setGwWithPalletAttribute()
    {
        return ($this->gw_per_package * $this->package_qty) + ($this->pallet_qty * $this->packingList->weight_per_pallet);
    }

    public function setNwKgAttribute()
    {
        return $this->nw_per_package * $this->package_qty;
    }

    public function getGwWithPalletAttribute()
    {
        return ($this->gw_per_package * $this->package_qty) + ($this->pallet_qty * $this->packingList->weight_per_pallet);
    }

    public function getNwKgAttribute()
    {
        return $this->nw_per_package * $this->package_qty;
    }

    public function getContactPersonAttribute()
    {
        $addressParts = array_filter([
            $this->contact_name,
            $this->contact_address
        ]);
    
        return implode(', ', $addressParts);
    }

    public function calculateWeights()
    {
        if (!$this->relationLoaded('packingList')) {
            $this->load('packingList');
        }

        $this->gw_with_pallet = ($this->gw_per_package * $this->package_qty)
                            + ($this->pallet_qty * optional($this->packingList)->weight_per_pallet);

        $this->nw_kg = $this->nw_per_package * $this->package_qty;
    }

    public function pallets()
    {
        return $this->hasManyThrough(
            Pallet::class,
            Stock::class,
            'packing_list_detail_id', // FK on stocks
            'pallet_id',                     // PK on pallets
            'packing_list_detail_id',                     // PK on packing_list_details
            'pallet_id'               // FK on stocks
        );
    }

    public function getPackageQtyPerPalletAttribute()
    {
        return $this->package_qty_per_pallet?? $this->product?->box_capacity_per_pallet;
    }
}

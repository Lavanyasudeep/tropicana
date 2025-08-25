<?php

namespace App\Models\Master\Inventory;

use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Inventory\{ PackingListDetail, InwardDetail};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductMaster extends Model
{
    use HasFactory;

    protected $table = 'cs_product_master';
    protected $primaryKey = 'product_master_id';
    protected $guarded = []; 
    public $timestamps = false;

    protected $appends = ['box_capacity_per_pallet'];

    public function grns()
    {
        return $this->belongsToMany(GRN::class, 'grndetail', 'ProductMasterID', 'GRNBatchID')
                    ->using(GRNDetail::class)
                    ->withPivot('quantity', 'price');
    }

    public function grnDetails()
    {
        return $this->belongsToMany(GRN::class, 'GRNDetail', 'ProductMasterID', 'GRNBatchID')
                    ->using(GRNDetail::class)
                    ->withPivot(['BatchNo', 'ReceivedQuantity']);
    }

    public function grnDetail()
    {
        return $this->belongsTo(GRNDetail::class, 'product_master_id', 'ProductMasterID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id'); 
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'product_category_id');
    }

    public function CatSvgIcon()
    {
        return $this->belongsTo(ProdCatSvgImg::class, 'product_category_id', 'category_id');
    }

    public function purchaseunit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id', 'unit_id');
    }

    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'product_master_id', 'product_id');
    }

    public function inwardDetails()
    {
        return $this->hasManyThrough(
            InwardDetail::class,           // Final model
            PackingListDetail::class,      // Intermediate model
            'product_id',                       // Foreign key on PackingListDetail (→ ProductMaster)
            'packing_list_detail_id',                  // Foreign key on InwardDetail (→ PackingListDetail)
            'product_master_id',                                      // Local key on ProductMaster
            'packing_list_detail_id'                                       // Local key on PackingListDetail
        );
    }

    public function getBoxCapacityPerHalfPalletAttribute($value)
    {
        return $value === null || $value === '' || $value == 0 ? 40 : $value;
    }

    public function getBoxCapacityPerFullPalletAttribute($value)
    {
        return $value === null || $value === '' || $value == 0 ? 40 : $value;
    }

    public function getBoxCapacityPerPalletAttribute()
    {
        // return $value === null || $value === '' || $value == 0 ? 40 : $value;
        $inwardDetail = $this->inwardDetails->first();
        $palletType = $inwardDetail?->slot?->palletType? $inwardDetail?->slot?->palletType?->type_name : 'half';

        if ($palletType === 'half') {
            return $this->box_capacity_per_half_pallet?? 40;
        } elseif ($palletType === 'full') {
            return $this->box_capacity_per_full_pallet?? 40;
        } else {
            return $this->box_capacity_per_full_pallet?? 40; // default
        }
    }

    public function getWeightPerBoxAttribute()
    {
        return $this->weight_per_box?? 1;
    }
}

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
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Stock extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'cs_stock';
    protected $primaryKey = 'stock_id';
    protected $guarded = []; 

    public $timestamps = true;
    
    protected static function booted()
    {
        parent::booted();
        
        static::saving(function ($stock) {
            // Ensure null values are treated as 0
            $in = is_numeric($stock->in_qty) ? $stock->in_qty : 0;
            $out = is_numeric($stock->out_qty) ? $stock->out_qty : 0;

            $stock->available_qty = $in - $out;
        });

        static::created(function ($stock) {
            if ($stock->slot) {
                $stock->slot->updateStatus();
            }

            if ($stock->pallet) {
                $stock->pallet->updateStatus();
            }
        });

        static::updating(function ($stock) {
            $stock->load('slot', 'pallet');

            if ($stock->slot) {
                $stock->slot->updateStatus();
            }

            if ($stock->pallet) {
                $stock->pallet->updateStatus();
            }

        });
        
        static::deleted(function ($stock) {
            if ($stock->slot) {
                $stock->slot->updateStatus();
            }
        });
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
    
    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function pickListDetail()
    {
        return $this->hasOne(PickListDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }
    
    public function product()
    {
        return $this->belongsTo(ProductMaster::class, 'product_id', 'product_master_id');
    }

    public function grnDetail()
    {
        return $this->hasOneThrough(
            GRNDetail::class,
            PackingListDetail::class,
            'grn_detail_id',              // FK on PackingListDetail pointing to GRNDetail
            'GRNProductID',              // Primary key on GRNDetail
            'packing_list_detail_id', // FK on stock pointing to PackingListDetail
            'packing_list_detail_id'    // Primary key on PackingListDetail
        );
    }

    public function inward()
    {
        return $this->belongsTo(InwardDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function getAvailableQtyAttribute()
    {
        return $this->attributes['available_qty'] ?? ($this->in_qty - $this->out_qty);
    }
}

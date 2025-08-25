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
use App\Models\Master\General\Status;

use App\Enums\MovementType;

use App\Services\Inventory\StockService;
use App\Services\Inventory\InventoryStatusTransitionService;

use App\Models\Traits\TracksStatusChanges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InwardDetail extends BaseModel
{
    use HasFactory, SoftDeletes, TracksStatusChanges;

    protected $table = 'cs_inward_detail';
    protected $primaryKey = 'inward_detail_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();

        static::created(function ($inwardDetail) {
            $inwardDetail->load('inward');

            $transitions = config('status_transitions.inward');
            $service = new InventoryStatusTransitionService($transitions);
            $service->apply($inwardDetail, 'created');
        });

        static::updating(function ($inwardDetail) {
            $inwardDetail->load('packingListDetail');
            
            $packingListDetail = $inwardDetail->packingListDetail;

            // if ($packingListDetail) {
            //     StockService::adjustQuantity($inwardDetail, $packingListDetail, $inwardDetail->quantity??0);
            // } else {
            //     Log::error('PackingListDetail not found for InwardDetail ID: ' . $inwardDetail->inward_detail_id);
            // }

            // if ($packingListDetail) {
            //     $originalQty = $inwardDetail->pallet->current_pallet_capacity??0;
            //     $currentQty = $inwardDetail->quantity??0;
            //     $diff = ($currentQty - $originalQty);

            //     Log::info("Adjusting stock for inwardDetail ID {$inwardDetail->inward_detail_id}, diff: {$diff}");

            //     if ($diff !== 0) {
            //         StockService::adjustQuantity($inwardDetail, $packingListDetail, $diff);
            //     }
            // } else {
            //     Log::error('PackingListDetail not found for InwardDetail ID: ' . $inwardDetail->inward_detail_id);
            // }

        //     if ($inwardDetail->pallet) {
        //         $inwardDetail->pallet->forceFill([
        //             'movement_type' => MovementType::In
        //         ])->save();
        //     }
        });

        // static::deleting(function ($inwardDetail) {
        //     $inwardDetail->load('pallet.stock');

        //     if ($inwardDetail->pallet) {
        //         $inwardDetail->pallet->delete();
        //     }
        // });

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
    
    public function inward()
    {
        return $this->belongsTo(Inward::class, 'inward_id', 'inward_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'packing_list_detail_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'inward_detail_id')
            ->where('table_name', $this->getTable());
    }

}

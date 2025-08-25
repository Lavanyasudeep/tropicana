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
use App\Services\Inventory\InventoryStatusTransitionService;

use App\Models\Traits\TracksStatusChanges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutwardDetail extends BaseModel
{
    use HasFactory, SoftDeletes, TracksStatusChanges;

    protected $table = 'cs_outward_detail';
    protected $primaryKey = 'outward_detail_id';
    protected $guarded = []; 

    public $timestamps = true;
    
    protected static function booted()
    {
        parent::booted();
        
        static::created(function ($outwardDetail) {
            $outwardDetail->load('outward');

            $transitions = config('status_transitions.outward');
            $service = new InventoryStatusTransitionService($transitions);
            $service->apply($outwardDetail, 'created');
        });

        static::updated(function ($outwardDetail) {
            $outwardDetail->load('outward');

            $outward = $outwardDetail->outward;

            $transitions = config('status_transitions.outward');
            $service = new InventoryStatusTransitionService($transitions);
            $service->apply($outward, 'cancelled');
        });

        static::deleted(function ($outwardDetail) {
            $outwardDetail->load('outward');

            $outward = $outwardDetail->outward;

            $transitions = config('status_transitions.outward');
            $service = new InventoryStatusTransitionService($transitions);
            $service->apply($outward, 'cancelled');
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
    
    public function outward()
    {
        return $this->belongsTo(Outward::class, 'outward_id', 'outward_id');
    }

    public function pickListDetail()
    {
        return $this->belongsTo(PickListDetail::class, 'picklist_detail_id', 'picklist_detail_id');
    }

    public function stock()
    {
        return $this->hasOneThrough(
            \App\Models\Stock::class,
            \App\Models\PickListDetail::class,
            'picklist_detail_id', // Foreign key on PickListDetail table
            'packing_list_detail_id', // Foreign key on stock table
            'outward_detail_id', // Local key on OutwardDetail table
            'picklist_detail_id' // Local key on PickListDetail table
        );
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }
    
    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'outward_detail_id')
            ->where('table_name', $this->getTable());
    }

}

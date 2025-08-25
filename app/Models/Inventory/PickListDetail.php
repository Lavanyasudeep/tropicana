<?php

namespace App\Models\Inventory;

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

use App\Models\Traits\TracksStatusChanges;

use App\Services\Inventory\InventoryStatusTransitionService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickListDetail extends Model
{
    use HasFactory, SoftDeletes, TracksStatusChanges;

    protected $table = 'cs_picklist_detail';
    protected $primaryKey = 'picklist_detail_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        static::created(function ($pickListDetail) {
            $pickListDetail->load('pickList');

            $transitions = config('status_transitions.picklist');
            $service = new InventoryStatusTransitionService($transitions);
            $service->apply($pickListDetail, 'created');
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
    
    public function pickList()
    {
        return $this->belongsTo(PickList::class, 'picklist_id', 'picklist_id');
    }

    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function inwardDetail()
    {
        return $this->belongsTo(InwardDetail::class, 'packing_list_detail_id', 'packing_list_detail_id');
    }

    public function outwardDetail()
    {
        return $this->belongsTo(OutwardDetail::class, 'picklist_detail_id', 'picklist_detail_id');
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
        return $this->hasMany(StatusUpdate::class, 'row_id', 'picklist_detail_id')
            ->where('table_name', $this->getTable());
    }
}

<?php

namespace App\Models\Purchase;

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

class GRN extends Model
{
    use HasFactory;

    protected $table = 'GRN';
    protected $primaryKey = 'GRNBatchID';
    protected $guarded = []; 
    protected $appends = ['grn_no', 'is_fully_assigned', 'assigned_percentage'];

    public function productMasters()
    {
        return $this->belongsToMany(ProductMaster::class, 'GRNDetail', 'GRNBatchID', 'ProductMasterID')
            ->using(GRNDetail::class)
            ->withPivot('ReceivedQuantity','WeightPerUnit', 'UnitID', 'BatchNo','GRNProductID', 'ProductMasterID')
            ->as('detail');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'supplier_id');
    }

    public function packingList()
    {
        return $this->belongsTo(PackingList::class, 'GRNBatchID', 'grn_id');
    }

    public function grnDetails()
    {
        return $this->hasMany(GRNDetail::class, 'GRNBatchID', 'GRNBatchID');
    }

    public function getGrnNoAttribute()
    {
        return $this->Prefix.$this->Suffix;
    }

    public function getIsFullyAssignedAttribute()
    {
        return $this->grnDetails->every(function ($detail) {
            return $detail->is_fully_assigned_to_cold_storage;
        });
    }

    public function getAssignedPercentageAttribute()
    {
        $totalQty = $this->grnDetails->count();

        if ($totalQty == 0) {
            return 0;
        }

        $assignedQty = $this->grnDetails->where('is_fully_assigned_to_cold_storage', true)->count();

        return round(($assignedQty / $totalQty) * 100, 2);
    }

}

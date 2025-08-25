<?php

namespace App\Models\Purchase;

use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom, ProductVariant};
use App\Models\Inventory\{Inward, InwardDetail, Outward, OutwardDetail, PackingList, PackingListDetail, PickList, PickListDetail, Stock, StockAdjustment};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class GRNDetail extends Pivot
{
    use HasFactory, HasRelationships;

    protected $table = 'GRNDetail';
    protected $primaryKey = 'GRNProductID';
    protected $guarded = []; 

    protected $appends = ['box_count', 'required_half_pallets', 'required_full_pallets', 'required_pallets', 'required_racks', 'is_fully_assigned_to_cold_storage', 'assigned_pallets'];

    public function grn()
    {
        return $this->belongsTo(GRN::class, 'GRNBatchID', 'GRNBatchID');
    }

    public function productMaster()
    {
        return $this->belongsTo(ProductMaster::class, 'ProductMasterID', 'product_master_id');
    }

    // public function stock()
    // {
    //     return $this->belongsTo(Stock::class, 'GRNProductID', 'grn_detail_id');
    // }

    public function packingListDetail()
    {
        return $this->belongsTo(PackingListDetail::class, 'GRNProductID', 'grn_detail_id');
    }

    public function stock()
    {
        return $this->hasOneThrough(
            Stock::class,
            PackingListDetail::class,
            'grn_detail_id',              // FK on PackingListDetail
            'packing_list_detail_id',     // FK on stock
            'GRNProductID',  // Local key on GRNDetail
            'packing_list_detail_id'    // Local key on PackingListDetail
        );
    }

    public function stocks()
    {
        return $this->hasManyThrough(
            Stock::class,
            PackingListDetail::class,
            'grn_detail_id',          // FK on PackingListDetail
            'packing_list_detail_id', // FK on stock
            'GRNProductID',                    // Local key on GRNDetail
            'packing_list_detail_id'                     // Local key on PackingListDetail
        );
    }

    // public function inward()
    // {
    //     return $this->belongsTo(Inward::class, 'GRNProductID', 'grn_detail_id');
    // }

    public function inward()
    {
        return $this->hasOneThrough(
            InwardDetail::class,
            PackingListDetail::class,
            'grn_detail_id',              // FK on PackingListDetail pointing to GRNDetail
            'packing_list_detail_id',     // FK on Inward pointing to PackingListDetail    
            'GRNProductID',             // Local key on GRNDetail
            'packing_list_detail_id'    // Local key on PackingListDetail
        );
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'UnitID', 'unit_id');
    }

    // public function assignedPallets()
    // {
    //     return $this->hasManyThrough(
    //         Pallet::class, // The final model we want to access
    //         Stock::class,   // The intermediate model
    //         'grn_detail_id',          // Foreign key on CSStock referencing Pallet
    //         'pallet_id',  // Foreign key on pallet referencing CSStock
    //         'GRNProductID',                 // Local key on Pallet
    //         'pallet_id'   // Local key on CSStock referencing pallet
    //     );
    // }

    public function assignedPallets()
    {
        return $this->hasManyDeep(
            Pallet::class,
            [PackingListDetail::class, Stock::class], // Intermediate models
            [
                'grn_detail_id',            // FK on PackingListDetail
                'packing_list_detail_id',  // FK on stock
                'pallet_id'                 // FK on stock
            ],
            [
                'GRNProductID', // Local key on GRNDetail
                'packing_list_detail_id', // Local key on PackingListDetail
                'pallet_id'  // Local key on Pallet
            ]
        );
    }

    public function getAssignedPalletsAttribute()
    {
        return $this->assignedPallets()->pluck('pallet_no')->implode(', ');
    }

    public function getBoxCountAttribute()
    {
        $product = $this->productMaster;
        $grnQuantity = $this->ReceivedQuantity;
        $unitWeight = $this->WeightPerUnit;
        $unitType = strtolower(trim($this->unit->conversion_unit ?? ''));

        return match ($unitType) {
            'half box', 'box', 'box small', 'nos', 'pkt', 'tray', 'bundle' => ceil($grnQuantity),
            'kg' => (!empty($product->weight_per_box) && $product->weight_per_box > 0)
                ? ceil(($grnQuantity * $unitWeight) / $product->weight_per_box)
                : ceil($grnQuantity),
            default => ceil($grnQuantity),
        };
    }

    public function getRequiredFullPalletsAttribute()
    {
        // return ceil($this->box_count / ($this->productMaster->box_capacity_per_full_pallet ?? 40));
        $boxesToAssign = $this->box_count;
        $capacityPerPallet = $this->productMaster->box_capacity_per_full_pallet ?? 0;

        $availableSlots = Slot::whereIn('status', ['empty', 'partial'])
                                ->orderBy('status', 'desc')
                                ->get();

        $assignments = [];
        
        if($availableSlots) {
            foreach ($availableSlots as $slot) {
                if($slot->has_pallet) {
                    $current = $slot->pallet->current_pallet_capacity??0; 
                    $remaining = $capacityPerPallet - $current;

                    if ($remaining <= 0) continue;

                    $assign = min($remaining, $boxesToAssign);
                    $assignments[] = [
                        'slot_id' => $slot->slot_id,
                        'current' => $current,
                        'assign_boxes' => $assign,
                        'after_assign' => $current + $assign,
                    ];

                    $boxesToAssign -= $assign;

                    if ($boxesToAssign <= 0) break;
                }
            }
        }

        $newPalletsRequired = ceil($boxesToAssign / $capacityPerPallet);

        return count($assignments) + $newPalletsRequired;
    }

    public function getRequiredHalfPalletsAttribute()
    {
        // return ceil($this->box_count / ($this->productMaster->box_capacity_per_full_pallet ?? 40));
        $boxesToAssign = $this->box_count;
        $capacityPerPallet = $this->productMaster->box_capacity_per_half_pallet ?? 0;

        $availableSlots = Slot::whereIn('status', ['empty', 'partial'])
                                ->orderBy('status', 'desc')
                                ->get();

        $assignments = [];
        
        if($availableSlots) {
            foreach ($availableSlots as $slot) {
                if($slot->has_pallet) {
                    $current = $slot->pallet->current_pallet_capacity??0; 
                    $remaining = $capacityPerPallet - $current;

                    if ($remaining <= 0) continue;

                    $assign = min($remaining, $boxesToAssign);
                    $assignments[] = [
                        'slot_id' => $slot->slot_id,
                        'current' => $current,
                        'assign_boxes' => $assign,
                        'after_assign' => $current + $assign,
                    ];

                    $boxesToAssign -= $assign;

                    if ($boxesToAssign <= 0) break;
                }
            }
        }

        $newPalletsRequired = ceil($boxesToAssign / $capacityPerPallet);

        return count($assignments) + $newPalletsRequired;
    }

    public function getRequiredPalletsAttribute()
    {
        // return ceil($this->box_count / ($this->productMaster->box_capacity_per_full_pallet ?? 40));
        $boxesToAssign = $this->box_count;
        $capacityPerPallet = $this->productMaster->box_capacity_per_pallet ?? 0;

        $availableSlots = Slot::whereIn('status', ['empty', 'partial'])
                                ->orderBy('status', 'desc')
                                ->get();

        $assignments = [];
        
        if($availableSlots) {
            foreach ($availableSlots as $slot) {
                if($slot->has_pallet) {
                    $current = $slot->pallet->current_pallet_capacity??0; 
                    $remaining = $capacityPerPallet - $current;

                    if ($remaining <= 0) continue;

                    $assign = min($remaining, $boxesToAssign);
                    $assignments[] = [
                        'slot_id' => $slot->slot_id,
                        'current' => $current,
                        'assign_boxes' => $assign,
                        'after_assign' => $current + $assign,
                    ];

                    $boxesToAssign -= $assign;

                    if ($boxesToAssign <= 0) break;
                }
            }
        }

        $newPalletsRequired = ceil($boxesToAssign / $capacityPerPallet);

        return count($assignments) + $newPalletsRequired;
    }

    public function getRequiredRacksAttribute()
    {
        $palletsPerRack = 1;
        return ceil($this->required_pallets / $palletsPerRack);
    }

    public function getIsFullyAssignedToColdStorageAttribute()
    {
        $csInQty = Inward::whereHas('packingListDetail', function ($q) {
                $q->where('grn_detail_id', $this->GRNProductID)
                ->where('product_id', $this->ProductMasterID);
            })
            ->with('inwardDetails')
            ->get()
            ->flatMap->inwardDetails
            ->sum('quantity') ?? 0;

        return $csInQty == $this->box_count;
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'ProductVariantID', 'product_variant_id');
    }

}

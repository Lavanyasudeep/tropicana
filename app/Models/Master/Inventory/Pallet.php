<?php

namespace App\Models\Master\Inventory;

use App\Models\BaseModel;
use App\Models\Inventory\Stock;

use App\Enums\MovementType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pallet extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'cs_pallets';
    protected $primaryKey = 'pallet_id';
    protected $guarded = []; 
    protected $appends = ['pallet_capacity', 'current_pallet_capacity', 'remaining_pallet_capacity', 'available_products', 'is_inward', 'is_outward', 'is_picked'];

    public $timestamps = true;
    
    protected $casts = [
        'movement_type' => MovementType::class,
    ];

     // Boot hook to auto-generate fields
    protected static function booted()
    {
        parent::booted();
        
        static::creating(function ($pallet) {
            $palletNo = $pallet->generatePalletNo();
            $pallet->pallet_no = $palletNo;
            $pallet->name = $palletNo;

            // Only generate position if related IDs are set
            if ($pallet->room && $pallet->rack && $pallet->slot) {
                $pallet->pallet_position = $pallet->generatePalletPosition();
            }
        });

        static::deleting(function ($pallet) {
            $pallet->load('stock');

            if ($pallet->stock) {
                $pallet->stock->delete();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function room()
    {
        return $this->belongsTo(StorageRoom::class, 'room_id', 'room_id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'block_id');
    }

    public function slot() {
        return $this->belongsTo(Slot::class, 'slot_id', 'slot_id');
    }

    public function rack() {
        return $this->belongsTo(Rack::class, 'rack_id', 'rack_id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'capacity_unit_id', 'unit_id');
    }

    public function palletType() {
        return $this->belongsTo(PalletType::class, 'pallet_type_id', 'pallet_type_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'pallet_id', 'pallet_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'pallet_id', 'pallet_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            ProductMaster::class, // The final model we want to access
            Stock::class,   // The intermediate model
            'pallet_id',          // Foreign key on CSStock referencing Pallet
            'product_master_id',  // Foreign key on ProductMaster referencing CSStock
            'pallet_id',                 // Local key on Pallet
            'product_id'   // Local key on CSStock referencing ProductMaster
        );
    }

    // ✅ Reusable function to generate pallet number
    public function generatePalletNo()
    {
        $lastPallet = self::where('pallet_no', 'LIKE', 'P%')
            ->orderByRaw('CAST(SUBSTRING(pallet_no, 2) AS UNSIGNED) DESC')
            ->first();

        $lastNumber = $lastPallet ? (int) substr($lastPallet->pallet_no, 1) : 0;

        return 'P' . ($lastNumber + 1);
    }

    // ✅ Reusable function to generate pallet position string
    public function generatePalletPosition()
    {
        return $this->room->name
            . '-' . $this->rack->block->block_no
            . '-' . $this->rack->rack_no
            . '-' . $this->slot->level_no
            . '-' . $this->slot->depth_no;
    }

    public function getPalletCapacityAttribute()
    {
        $stock = Stock::where('pallet_id', $this->pallet_id)->get();

        $packingListDtl = optional($stock->first())->packingListDetail;
    
        $palletCapacity = optional($packingListDtl)->package_qty_per_pallet ?? 0;

        return $this->capacity?? $palletCapacity;
    }

    public function getCurrentPalletCapacityAttribute()
    {
        // $stocks = Stock::where('pallet_id', $this->pallet_id)->get();

        // if ($stocks->isEmpty()) {
        //     return 0;
        // }

        // $csInQty = $stocks->sum(function ($stock) {
        //     return Inward::where('packing_list_detail_id', $stock->packing_list_detail_id)
        //         ->whereHas('inwardDetails', function ($query) use ($stock) {
        //             $query->where('pallet_id', $stock->pallet_id);
        //         })
        //         ->with(['inwardDetails' => function ($query) use ($stock) {
        //             $query->where('pallet_id', $stock->pallet_id);
        //         }])
        //         ->get()
        //         ->flatMap(function ($inward) {
        //             return $inward->inwardDetails;
        //         })
        //         ->sum('quantity') ?? 0;
        // });

        // $csOutQty = $stocks->sum(function ($stock) {
        //     return Outward::with(['outwardDetails' => function ($query) use ($stock) {
        //             $query->where('pallet_id', $stock->pallet_id);
        //         }])
        //         ->whereHas('outwardDetails', function ($query) use ($stock) {
        //             $query->where('pallet_id', $stock->pallet_id);
        //         })
        //         ->whereHas('outwardDetails.pickListDetail.packingListDetail', function ($query) use ($stock) {
        //             $query->where('packing_list_detail_id', $stock->packing_list_detail_id);
        //         })
        //         ->get()
        //         ->flatMap(function ($outward) {
        //             return $outward->outwardDetails;
        //         })
        //         ->sum('quantity') ?? 0;
        // });

        // return $csInQty - $csOutQty;
        return $this->stock()
                    ->selectRaw('SUM(available_qty) as total')
                    ->value('total') ?? 0;
    }

    public function getRemainingPalletCapacityAttribute()
    {
        return ($this->pallet_capacity - $this->current_pallet_capacity);
    }

    public function updateStatus() 
    {
        $newStatus = match (true) {
            $this->current_pallet_capacity <= 0 => 'empty',
            $this->pallet_capacity > 0 && $this->current_pallet_capacity >= $this->pallet_capacity => 'full',
            default => 'partial',
        };

        if ($this->status !== $newStatus) {
            $this->status = $newStatus;
            return $this->save();
        }

        return false;
    }

    // public function availableProducts()
    // {
    //     return $this->hasMany(CSStock::class, 'pallet_id', 'pallet_id')
    //         ->selectRaw('product_master_id, SUM(CASE WHEN movement_type = "in" THEN quantity ELSE -quantity END) as net_quantity')
    //         ->groupBy('product_master_id')
    //         ->having('net_quantity', '>', 0)
    //         ->with('productmaster'); 
    // }

    // public function getAvailableProductsAttribute()
    // {
    //     return Stock::selectRaw('product_id, SUM(CASE WHEN movement_type IN ("in", "picked") THEN quantity ELSE -quantity END) as net_quantity')
    //         ->where('pallet_id', $this->pallet_id) 
    //         ->groupBy('product_id')
    //         ->having('net_quantity', '>', 0)
    //         ->with(['product.CatSvgIcon'])
    //         ->get();
    // }
    public function getAvailableProductsAttribute()
    {
        return $this->stock()
                    ->with('product.catSvgIcon')
                    ->select('pallet_id', DB::raw('SUM(available_qty) as total_available_qty'))
                    // ->select('product_id', 'packing_list_detail_id', 'pallet_id', DB::raw('SUM(available_qty) as total_available_qty'))
                    // ->groupBy('product_id', 'pallet_id', 'packing_list_detail_id')
                    ->groupBy('pallet_id')
                    ->having('total_available_qty', '>', 0)
                    ->get();

    }

    public function getIsInwardAttribute()
    {
        return $this->movement_type === MovementType::In;
    }

    public function getIsOutwardAttribute()
    {
        return $this->movement_type === MovementType::Out;
    }

    public function getIsPickedAttribute()
    {
        return $this->movement_type === MovementType::Picked;
    }

    public function getPalletStatus()
    {
        $capacityUsed = $this->current_pallet_capacity ?? 0;
        $capacityTotal = $this->pallet_capacity ?? 1; // avoid division by 0
        $percent = ($capacityUsed / $capacityTotal) * 100;

        if ($percent >= 95) {
            $batteryIcon = 'fa-battery-full';
            $batteryColor = 'text-success';
        } elseif ($percent >= 70) {
            $batteryIcon = 'fa-battery-three-quarters';
            $batteryColor = 'text-success';
        } elseif ($percent >= 40) {
            $batteryIcon = 'fa-battery-half';
            $batteryColor = 'text-warning';
        } elseif ($percent >= 10) {
            $batteryIcon = 'fa-battery-quarter';
            $batteryColor = 'text-warning';
        } else {
            $batteryIcon = 'fa-battery-empty';
            $batteryColor = 'text-danger';
        }

        return [
            'battery_icon' => $batteryIcon,
            'battery_color' => $batteryColor,
            'capacity_used' => $capacityUsed,
            'capacity_total' => $capacityTotal,
            'percent' => $percent
        ];
    }
}

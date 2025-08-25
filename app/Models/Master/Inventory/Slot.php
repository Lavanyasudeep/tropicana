<?php

namespace App\Models\Master\Inventory;

use App\Models\Inventory\Stock;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $table = 'cs_slots';
    protected $primaryKey = 'slot_id';
    protected $guarded = []; 
    protected $appends = ['has_pallet'];

    public $timestamps = true;
    
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function room()
    {
        return $this->belongsTo(StorageRoom::class, 'room_id', 'room_id');
    }
    
    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_id', 'rack_id');
    }

    public function pallet()
    {
        return $this->hasOne(Pallet::class, 'slot_id', 'slot_id');
    }

    public function palletType() {
        return $this->belongsTo(PalletType::class, 'pallet_type_id', 'pallet_type_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'slot_id', 'slot_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'slot_id', 'slot_id');
    }

    public function getHasPalletAttribute()
    {
        return $this->status!=='empty'?1:0;
    }

    public function updateStatus() 
    {
        if ($this->pallet && $this->pallet->current_pallet_capacity <= 0) {
            $this->status = 'empty';
        } elseif ($this->pallet->pallet_capacity > 0 && $this->pallet->current_pallet_capacity >= $this->pallet->pallet_capacity) {
            $this->status = 'full';
        } else {
            $this->status = 'partial';
        }
    
        return $this->save(); 
    }

    public function getSlotStatus()
    {
        $capacityUsed = $this->pallet? $this->pallet->current_pallet_capacity : 0;
        $capacityTotal = $this->pallet? $this->pallet->pallet_capacity : 1; // avoid division by 0
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

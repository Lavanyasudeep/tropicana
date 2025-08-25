<?php

namespace App\Models\Master\Inventory;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $table = 'cs_racks';
    protected $primaryKey = 'rack_id';
    protected $guarded = []; 
    protected $appends = [ 'rack_count', 'all_slots_exist'];

    public $timestamps = true;
    
    // Boot method to auto-generate slots
    protected static function booted()
    {
         static::created(function ($rack) {
            try {
                $rack->generateSlots();
            } catch (\Exception $e) {
                \Log::error('Slot generation failed for Rack ID ' . $rack->id . ': ' . $e->getMessage());
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
    
    public function slots()
    {
        return $this->hasMany(Slot::class, 'rack_id', 'rack_id');
    }

    public function pallets()
    {
        return $this->hasMany(Pallet::class, 'rack_id', 'rack_id');
    }

    public function getRackCountAttribute()
    {
        return $this->active()->count();
    }

    public function getAllSlotsExistAttribute()
    {
        return $this->slots->count() === $this->no_of_levels * $this->no_of_depth;
    }
    
    public function generateSlots()
    {
        // Prevent generation if pallets already have products
        foreach ($this->slots as $slot) {
            if ($slot->pallet && $slot->pallet->availableProducts()->exists()) {
                throw new \Exception('Cannot regenerate slots. Products already assigned.');
            }
        }

        // Delete old slots
        Slot::where('rack_id', $this->rack_id)->delete();

        $levels = $this->no_of_levels;
        $depth = $this->no_of_depth;
        $rackNo = strtoupper($this->rack_no);
        $roomNo = strtoupper($this->room->name ?? '');

        $lastSlot = Slot::where('slot_no', 'LIKE', 'S%')
            ->orderByRaw('CAST(SUBSTRING(slot_no, 2) AS UNSIGNED) DESC')
            ->where('rack_id', $this->rack_id)
            ->first();

        $lastNumber = $lastSlot ? (int) substr($lastSlot->slot_no, 1) : 0;
        $counter = $lastNumber + 1;

        for ($l = 1; $l <= $levels; $l++) {
            for ($d = 1; $d <= $depth; $d++) {
                $slotNo = 'S' . $counter++;

                Slot::create([
                    'room_id' => $this->room_id,
                    'rack_id' => $this->rack_id,
                    'slot_no' => $slotNo,
                    'name' => $slotNo,
                    'level_no' => "L{$l}",
                    'depth_no' => "D{$d}",
                ]);
            }
        }
    }

    
}

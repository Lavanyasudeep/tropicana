<?php

namespace App\Models\Master\Inventory;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'cs_blocks';
    protected $primaryKey = 'block_id';
    protected $guarded = []; 

    public $timestamps = true;
    
    // public function zones()
    // {
    //     return $this->hasMany(Zone::class, 'room_id');
    // }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    public function room() {
        return $this->belongsTo(StorageRoom::class, 'room_id', 'room_id');
    }

    
}

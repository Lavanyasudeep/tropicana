<?php

namespace App\Models\Master\Inventory;

use Illuminate\Database\Eloquent\Model;

class StorageRoom extends Model
{
    protected $table = 'cs_storage_rooms';
    protected $primaryKey = 'room_id';
    protected $guarded = []; 
    protected $appends = [ 'rack_count'];

    public $timestamps = true;
    
    // public function zones()
    // {
    //     return $this->hasMany(Zone::class, 'room_id');
    // }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    public function racks() {
        return $this->hasMany(Rack::class, 'room_id', 'room_id');
    }
    
    public function getRackCountAttribute()
    {
        return $this->racks->count();
    }
    
}

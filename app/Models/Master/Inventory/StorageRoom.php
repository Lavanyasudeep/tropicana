<?php

namespace App\Models\Master\Inventory;

use App\Models\Master\General\ProductType;

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
    
    public function productType() {
        return $this->belongsTo(ProductType::class, 'storage_product_type_id', 'product_type_id');
    }

    public function warehouseUnit() {
        return $this->belongsTo(WarehouseUnit::class, 'warehouse_unit_id', 'wu_id');
    }

    public function racks() {
        return $this->hasMany(Rack::class, 'room_id', 'room_id');
    }
    
    public function getRackCountAttribute()
    {
        return $this->racks->count();
    }
    
}

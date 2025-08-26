<?php

namespace App\Models\Master\Inventory;

use App\Models\Master\General\ProductType;

use Illuminate\Database\Eloquent\Model;

class WarehouseUnit extends Model
{
    protected $table = 'cs_warehouse_unit';
    protected $primaryKey = 'wu_id';
    protected $guarded = []; 

    public $timestamps = true;
    
    protected static function booted()
    {
        parent::booted();
        
        static::creating(function ($unit) {
            $unitNo = $unit->generateUnitNo();
            $unit->wu_no = $unitNo;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    public function rooms() {
        return $this->hasMany(Room::class, 'wu_id', 'wu_id');
    }

    public function docks() {
        return $this->hasMany(Dock::class, 'wu_id', 'warehouse_unit_id');
    }
    
    public function productType() {
        return $this->belongsTo(ProductType::class, 'storage_product_type_id', 'product_type_id');
    }

    // ✅ Reusable function to generate Unit number
    public function generateUnitNo()
    {
        $lastUnit = self::where('wu_no', 'LIKE', 'WU%')
            ->orderByRaw('CAST(SUBSTRING(wu_no, 3) AS UNSIGNED) DESC')
            ->first();

        $lastNumber = $lastUnit ? (int) substr($lastUnit->wu_no, 2) : 0;

        return 'WU' . ($lastNumber + 1);
    }

}

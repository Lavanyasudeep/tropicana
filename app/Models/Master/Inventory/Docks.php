<?php

namespace App\Models\Master\Inventory;

use App\Models\Master\Inventory\WarehouseUnit;

use Illuminate\Database\Eloquent\Model;

class Docks extends Model
{
    protected $table = 'cs_docks';
    protected $primaryKey = 'dock_id';
    protected $guarded = []; 

    public $timestamps = true;
    
    protected static function booted()
    {
        parent::booted();
        
        static::creating(function ($dock) {
            $dockNo = $dock->generateDockNo();
            $dock->dock_no = $dockNo;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    public function warehouseUnit() {
        return $this->belongsTo(WarehouseUnit::class, 'warehouse_unit_id', 'wu_id');
    }

    // ✅ Reusable function to generate Dock number
    public function generateDockNo()
    {
        $lastDock = self::where('dock_no', 'LIKE', 'WU%')
            ->orderByRaw('CAST(SUBSTRING(dock_no, 3) AS UNSIGNED) DESC')
            ->first();

        $lastNumber = $lastDock ? (int) substr($lastDock->dock_no, 2) : 0;

        return 'DOCK' . ($lastNumber + 1);
    }

}

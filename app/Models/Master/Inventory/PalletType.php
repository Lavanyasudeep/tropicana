<?php

namespace App\Models\Master\Inventory;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PalletType extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_pallet_types';
    protected $primaryKey = 'pallet_type_id';
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function isActive()
    {
        return $this->active? 1:0;
    }

    public function getTypeNameAttribute($value)
    {
        return $value === null || $value === '' ? 'half' : $value;
    }
}
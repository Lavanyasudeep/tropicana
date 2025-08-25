<?php

namespace App\Models\Master\General;

use App\Models\BaseModel;
use App\Models\{ User, RoleMenuPermission};
use App\Models\Master\General\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends BaseModel
{
    use HasFactory;

    protected $table = 'cs_menu';
    protected $primaryKey = 'menu_id';
    protected $guarded = []; 

    public $timestamps = false;

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($menu) {
            $menu->company_id = auth()->user()->company_id ?? 1;

            // Automatically set sort_order based on parent_id
            $maxSort = Menu::where('parent_id', $menu->parent_id)->max('sort_order');
            $menu->sort_order = $maxSort ? $maxSort + 1 : 1;
        });

    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('children')->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function roleMenuPermissions()
    {
        return $this->hasMany(RoleMenuPermission::class, 'menu_id', 'menu_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'cs_role_menu_permission', 'menu_id', 'role_id')
            ->withPivot('permission_id')
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'cs_role_menu_permission', 'menu_id', 'permission_id')
            ->withPivot('role_id')
            ->withTimestamps();
    }
}

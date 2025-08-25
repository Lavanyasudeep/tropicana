<?php

namespace App\Models;

use App\Models\{ RoleMenuPermission};
use App\Models\Master\General\Menu;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'cs_permission';
    protected $primaryKey = 'permission_id';

    protected $fillable = ['code', 'name'];

    public $timestamps = true;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'cs_role_menu_permission', 'permission_id', 'role_id')
            ->withPivot('menu_id')
            ->withTimestamps();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'cs_role_menu_permission', 'permission_id', 'menu_id')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function roleMenuPermissions()
    {
        return $this->hasMany(RoleMenuPermission::class, 'permission_id', 'permission_id');
    }
}

<?php

namespace App\Models;

use App\Models\{ RoleMenuPermission};
use App\Models\Master\General\Menu;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'cs_role';
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'company_id',
        'role_name',
        'role_desc',
        'mobile_access',
        'active',
        'del_status',
        'short_name',
        'duties_and_resp',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public $timestamps = false;

    public function menuPermissions()
    {
        return $this->hasMany(RoleMenuPermission::class, 'role_id', 'role_id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'cs_role_menu_permission', 'role_id', 'menu_id')
            ->withPivot('permission_id')
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'cs_role_menu_permission', 'role_id', 'permission_id')
            ->withPivot('menu_id')
            ->withTimestamps();
    }
    
}

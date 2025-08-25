<?php

namespace App\Models;

use App\Models\{ Role, Permission};
use App\Models\Master\General\{ Menu};

use Illuminate\Database\Eloquent\Model;

class RoleMenuPermission extends Model
{
    protected $table = 'cs_role_menu_permission';
    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'menu_id',
        'permission_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'permission_id');
    }
}


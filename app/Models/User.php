<?php

namespace App\Models;

use App\Models\{ Company, Branch};
use App\Models\Master\HR\{ Employee};

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'cs_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/avatars/' . $this->avatar)
            : asset('images/default-avatar.jpg');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'role_id', 'role_id');
    }

    public function hasMenuPermission($menuId)
    {
        // Assuming role->menuPermissions() is set up correctly
        return $this->role
            ->menuPermissions()
            ->where('menu_id', $menuId)
            ->exists();
    }

    public function hasPermission($menuId, $code)
    {
        $permission = Permission::where('code', $code)->first();
        if (!$permission) return false;

        return $this->role->menus()
            ->where('cs_menu.menu_id', $menuId)
            ->wherePivot('permission_id', $permission->permission_id)
            ->exists();
    }
}

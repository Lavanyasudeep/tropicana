<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;

use App\Models\Master\General\Menu;
use App\Models\RoleMenuPermission;

class MenuBuilder
{
    public static function getMenu()
    {
        $user = Auth::user();
       
        if (!$user) {
            return [];
        }
        
        // Get role(s) of the user
        $roles = $user->roles->pluck('role_id')->toArray();

        // Get menus accessible by user’s roles
        $menuItems = Menu::with(['children' => function($q) use ($roles) {
                            $q->whereHas('roleMenuPermissions', function($qq) use ($roles) {
                                $qq->whereIn('role_id', $roles);
                            })->orderBy('sort_order');
                        }])
                        ->whereHas('roleMenuPermissions', function($q) use ($roles) {
                            $q->whereIn('role_id', $roles);
                        })
                        ->whereNull('parent_id')
                        ->orderBy('sort_order')
                        ->get();
        
        return self::formatMenu($menuItems);
    }

    private static function formatMenu($menus)
    {
        $menuArray = [];
        foreach ($menus as $menu) {
            // Skip if user doesn’t have permission
            if ($menu->roleMenuPermissions->isEmpty()) {
                continue;
            }

            $item = [
                'text' => $menu->menu_name,
                'url'  => $menu->path,
                'icon' => $menu->icon_class,
            ];

            if ($menu->children->count()) {
                $filteredChildren = $menu->children->filter(function($child) {
                    return $child->roleMenuPermissions->isNotEmpty();
                });
                if ($filteredChildren->count()) {
                    $item['submenu'] = self::formatMenu($filteredChildren);
                }
            }

            if (empty($item['submenu']) && empty($item['url'])) {
                $item['url'] = '#';
            }

            $menuArray[] = $item;
        }
        return $menuArray;
    }

}

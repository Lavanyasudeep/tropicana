<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $currentPath = $request->route()->uri();

        // find menu by path
        $menu = \App\Models\Master\General\Menu::where('path', $currentPath)->first();

        if ($menu && !$user->role->menus->contains($menu->menu_id)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

}

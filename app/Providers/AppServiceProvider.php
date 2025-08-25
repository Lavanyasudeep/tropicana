<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use App\Models\Inventory\InwardDetail;
use App\Models\Inventory\PickListDetail;
use App\Models\Inventory\OutwardDetail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(100);

        Relation::morphMap([
            'cs_inward_detail' => InwardDetail::class,
            'cs_picklist_detail' => PickListDetail::class,
            'cs_outward_detail' => OutwardDetail::class,
            // add more as needed
        ]);

        \View::composer('*', function ($view) {
            if (auth()->check()) {
                \Config::set('adminlte.menu', \App\Helper\MenuBuilder::getMenu());
            }
        });
    }

}

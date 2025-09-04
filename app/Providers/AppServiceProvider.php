<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

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

        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->check()) {
                // Inject sidebar search
                $event->menu->add([
                    'type' => 'navbar-search',
                    'text' => 'Search',
                    'topnav_right' => true,
                ]);

                $event->menu->add([
                    'type' => 'sidebar-menu-search',
                    'text' => 'Search',
                    'topnav' => false,
                ]);

                $event->menu->add([
                    'type' => 'fullscreen-widget',
                    'topnav_right' => true,
                ]);

                $event->menu->add([
                        'type' => 'navbar-notification',
                        'topnav_right' => true,
                        'id'   => 'notif',
                        'icon' => 'fas fa-bell',
                        'label_color' => 'danger',
                        'dropdown_mode' => true,
                        'header' => 'Notifications',
                        'label' => 3, // Optional: shows badge count
                        'items' => [
                            [
                                'text' => 'New Invoice Created',
                                'icon' => 'fas fa-file-invoice',
                                'url'  => 'admin/invoices',
                            ],
                            [
                                'text' => 'Stock Alert: Chamber CR-102',
                                'icon' => 'fas fa-temperature-high',
                                'url'  => 'admin/inventory',
                            ],
                        ],
                ]);
                
                $menuItems = \App\Helper\MenuBuilder::getMenu();
                foreach ($menuItems as $item) {
                    $event->menu->add($item);
                }
            }
        });
    }

}

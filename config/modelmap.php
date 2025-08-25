<?php

return [
    'cs_users' => \App\Models\User::class,
    'cs_storage_rooms' => \App\Models\Master\Inventory\StorageRoom::class,
    'cs_racks' => \App\Models\Master\Inventory\Rack::class,
    'cs_slots' => \App\Models\Master\Inventory\Slot::class,
    'cs_pallets' => \App\Models\Master\Inventory\Pallet::class,
    'cs_stock' => \App\Models\Inventory\Stock::class,
    
    // Add more as needed
];


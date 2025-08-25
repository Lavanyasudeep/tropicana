<?php

namespace App\Observers;

use App\Models\Inventory\PackingListDetail;

class PackingListDetailObserver
{
    public function saving(PackingListDetail $detail)
    {
        $detail->gw_with_pallet = ($detail->gw_per_package * $detail->package_qty) +
                                ($detail->pallet_qty * optional($detail->packingList)->weight_per_pallet);
        $detail->nw_kg = $detail->nw_per_package * $detail->package_qty;
    }

}

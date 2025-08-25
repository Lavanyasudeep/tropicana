<?php
namespace App\Services\Inventory;

use App\Models\Inventory\Stock;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StockService
{
    public static function adjustQuantity($detail, $packingListDetail, int $quantity)
    {
        if (!$packingListDetail || !$packingListDetail->product_id) {
            throw new \Exception('Invalid packing list detail provided');
        }

        $conditions = [
            'product_id' => $packingListDetail->product_id,
            'category_id' => $packingListDetail->variety_id,
            'batch_no' => $packingListDetail->lot_no,
            'expiry_date' => $packingListDetail->expiry_date,
            // 'room_id' => $detail->room_id,
            // 'rack_id' => $detail->rack_id,
            // 'slot_id' => $detail->slot_id,
            'pallet_id' => $detail->pallet_id,
            'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
        ];

        $existing = Stock::where($conditions)->first();

        if ($existing) {
            // $updated = $existing->update([
            //     'room_id' => $detail->room_id,
            //     'rack_id' => $detail->rack_id,
            //     'slot_id' => $detail->slot_id,
            //     'pallet_id' => $detail->pallet_id,
            //     'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
            //     'in_qty' => DB::raw("in_qty + " . max(0, $quantity)),
            //     'out_qty' => DB::raw("out_qty + " . max(0, -$quantity)),
            // ]);
            $existing->fill([
                'room_id' => $detail->room_id,
                'rack_id' => $detail->rack_id,
                'slot_id' => $detail->slot_id,
                'pallet_id' => $detail->pallet_id,
                'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
            ]);
            
            if ($detail->status == 'cancelled' || $detail->status == 'rejected') {
                $existing->in_qty -= max(0, $quantity);
            } else {
                $existing->in_qty += max(0, $quantity);
            }

            if ($detail->status == 'cancelled' || $detail->status == 'rejected') {
                $existing->out_qty -= max(0, -$quantity);
            } else {
                $existing->out_qty += max(0, -$quantity);
            }

            if (!$existing->save()) {
                Log::error("Failed to update stock", ['id' => $existing->stock_id]);
            }

            return $existing;
        } else {
            try {
                $stock = Stock::create([
                    'product_id' => $packingListDetail->product_id,
                    'category_id' => $packingListDetail->variety_id,
                    'batch_no' => $packingListDetail->lot_no,
                    'expiry_date' => $packingListDetail->expiry_date,
                    'room_id' => $detail->room_id,
                    'rack_id' => $detail->rack_id,
                    'slot_id' => $detail->slot_id,
                    'pallet_id' => $detail->pallet_id,
                    'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
                    'in_qty' => max(0, $quantity),
                    'out_qty' => max(0, -$quantity)
                ]);
                Log::info("Stock created", ['id' => $stock->stock_id]);
                return $stock;
            } catch (\Exception $e) {
                Log::error("Failed to create stock: " . $e->getMessage(), [
                    'conditions' => $conditions,
                    'quantity' => $quantity,
                ]);
                throw $e;
            }
        }

    }
}


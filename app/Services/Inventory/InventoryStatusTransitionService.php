<?php

namespace App\Services\Inventory;

use App\Services\Inventory\StockService;

use App\Models\Inventory\Inward;
use App\Models\Inventory\InwardDetail;
use App\Models\Inventory\PickList;
use App\Models\Inventory\PickListDetail;
use App\Models\Inventory\Outward;
use App\Models\Inventory\OutwardDetail;
use App\Models\Master\General\Status;

use App\Enums\MovementType;

use Illuminate\Support\Facades\Log;
use Exception;

class InventoryStatusTransitionService
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('status_transitions');
    }

    public function getNextAllowed(string $type, string $currentStatus): array
    {
        return $this->config[$type][$currentStatus]['next'] ?? [];
    }

    public function isAllowed(string $type, string $from, string $to): bool
    {
        return in_array($to, $this->getNextAllowed($type, $from));
    }

    protected function getStatusValue($status): ?string
    {
        return $status instanceof Status ? $status->status_name : $status;
    }

    public function apply($model, string $newStatus): void
    {
        $type = $model->doc_type ?? $this->guessDocTypeFromModel($model);

        $newStatusValue = $this->getStatusValue($newStatus);

        if ($this->isHeaderModel($model)) {
            foreach ($model->details as $detail) {
                if (!$this->isAllowed($type, $this->getStatusValue($detail->status), $newStatusValue)) {
                    throw new Exception("Invalid status transition from {$this->getStatusValue($detail->status)} to {$newStatusValue} for {$type}");
                }
            }
        } else {
            if ($newStatusValue !== 'created' && !$this->isAllowed($type, $this->getStatusValue($model->status), $newStatusValue)) {
                throw new Exception("Invalid status transition from {$this->getStatusValue($model->status)} to {$newStatusValue} for {$type}");
            }
        }

        $model->status = $newStatusValue;
        $model->save();
        Log::info("Updated {$type} ID {$model->id} to {$newStatusValue}");

        if ($this->isHeaderModel($model)) {
            foreach ($model->details as $detail) {
                $this->apply($detail, $newStatusValue);
            }
        }

        $effects = $this->getEffects($type, $newStatusValue);
        foreach ($effects as $effect) {
            $this->handleEffect($model, $effect);
        }

        Log::info("Applied effects to {$type} ID {$model->id}", ['effects' => $effects]);
    }

    protected function getEffects(string $type, string $status): array
    {
        return $this->config[$type][$status]['effects'] ?? [];
    }

    protected function isHeaderModel($model): bool
    {
        return $model instanceof \App\Models\Inventory\Inward
            || $model instanceof \App\Models\Inventory\PickList
            || $model instanceof \App\Models\Inventory\Outward;
    }

    protected function guessDocTypeFromModel($model): string
    {
        if (isset($model->doc_type) && $model->doc_type) {
            return $model->doc_type;
        }

        return match (true) {
            $model instanceof Inward, 
            $model instanceof InwardDetail => 'inward',

            $model instanceof PickList,
            $model instanceof PickListDetail => 'picklist',

            $model instanceof Outward,
            $model instanceof OutwardDetail => 'outward',

            default => throw new \Exception("Unable to determine doc_type for model"),
        };

    }

    protected function handleEffect($model, string $effect): void
    {
        match ($effect) {
            'update_stock' => $this->updateStock($model),

            'set_pallet_in' => $this->setPalletMovementType($model, MovementType::In),
            'set_pallet_out' => $this->setPalletMovementType($model, MovementType::Out),
            'set_pallet_picked' => $this->setPalletMovementType($model, MovementType::Picked),

            'set_pallet_cancelled' => $this->setPalletStatus($model, 'cancelled'),
            'set_pallet_rejected' => $this->setPalletStatus($model, 'rejected'),

            'set_inward_detail_created' => $this->setInwardDetailStatus($model, 'created'),
            'set_inward_detail_approved' => $this->setInwardDetailStatus($model, 'approved'),
            'set_inward_detail_rejected' => $this->setInwardDetailStatus($model, 'rejected'),
            'set_inward_detail_finalized' => $this->setInwardDetailStatus($model, 'finalized'),
            'set_inward_detail_picked' => $this->setInwardDetailStatus($model, 'picked'),
            'set_inward_detail_cancelled' => $this->setInwardDetailStatus($model, 'cancelled'),
            'set_inward_detail_out' => $this->setInwardDetailStatus($model, 'out'),
            'set_inward_detail_dispatched' => $this->setInwardDetailStatus($model, 'dispatched'),

            'set_inward_details_out' => $this->setInwardDetailsStatus($model, 'out'),
            'set_inward_details_dispatched' => $this->setInwardDetailsStatus($model, 'dispatched'),

            'set_picklist_detail_created' => $this->setPickListDetailStatus($model, 'created'),
            'set_picklist_detail_approved' => $this->setPickListDetailStatus($model, 'approved'),
            'set_picklist_detail_rejected' => $this->setPickListDetailStatus($model, 'rejected'),
            'set_picklist_detail_finalized' => $this->setPickListDetailStatus($model, 'finalized'),
            'set_picklist_detail_cancelled' => $this->setPickListDetailStatus($model, 'cancelled'),
            'set_picklist_detail_out' => $this->setPickListDetailStatus($model, 'out'),
            'set_picklist_detail_dispatched' => $this->setPickListDetailStatus($model, 'dispatched'),

            'set_picklist_details_finalized' => $this->setPickListDetailsStatus($model, 'finalized'),
            'set_picklist_details_dispatched' => $this->setPickListDetailsStatus($model, 'dispatched'),

            'set_outward_detail_created' => $this->setOutwardDetailStatus($model, 'created'),
            'set_outward_detail_approved' => $this->setOutwardDetailStatus($model, 'approved'),
            'set_outward_detail_rejected' => $this->setOutwardDetailStatus($model, 'rejected'),
            'set_outward_detail_finalized' => $this->setOutwardDetailStatus($model, 'finalized'),
            'set_outward_detail_dispatched' => $this->setOutwardDetailStatus($model, 'dispatched'),

            default => Log::warning("Unknown effect: {$effect}"),
        };
    }

    protected function updateStock($model): void
    {
        if ($this->isHeaderModel($model)) {
            if (!method_exists($model, 'details')) {
                Log::warning('Model missing details() for stock update');
                return;
            }

            foreach ($model->details as $detail) {
                $packingListDetail = $model instanceof \App\Models\Inventory\Inward ? $detail->packingListDetail : $detail->pickListDetail->packingListDetail;
                if ($packingListDetail) {
                    $qty = $model instanceof \App\Models\Inventory\Inward ? $detail->quantity : -$detail->quantity;
                    StockService::adjustQuantity($detail, $packingListDetail, $qty);
                }
            }
        } else {
            $packingListDetail = $model instanceof \App\Models\Inventory\InwardDetail ? $model->packingListDetail : $model->pickListDetail->packingListDetail;
            if ($packingListDetail) {
                $qty = $model instanceof \App\Models\Inventory\InwardDetail ? $model->quantity : -$model->quantity;
                StockService::adjustQuantity($model, $packingListDetail, $qty);
            }
        }
    }

    protected function setPalletMovementType($model, $movementType): void
    {
        if (!method_exists($model, 'details')) return;

        foreach ($model->details as $detail) {
            if ($detail->pallet) {
                $detail->pallet->update(['movement_type' => $movementType]);
            }
        }
    }

    protected function setPalletStatus($model, $status): void
    {
        $statusValue = $this->getStatusValue($status);

        if ($this->isHeaderModel($model)) {
            $model->load('details');
            foreach ($model->details as $detail) {
                $detail->pallet->update(['status' => $statusValue]);
                Log::info("Updated InwardDetail ID {$detail->inward_detail_id} to status {$statusValue}");
            }
        } else {
            $model->pallet->update(['status' => $statusValue]);
            Log::info("Updated single InwardDetail ID {$model->inward_detail_id} to status {$statusValue}");
        }
    }

    // protected function setInwardDetailStatus($model, $status): void
    // {
    //     $model->update(['status' => $status]);
    // }

    protected function setInwardDetailStatus($model, $status): void
    {
        $statusValue = $this->getStatusValue($status);

        if ($this->isHeaderModel($model)) {
            $model->load('details');

            foreach ($model->details as $detail) {
                $detail->update(['status' => $statusValue]);
                Log::info("Updated InwardDetail ID {$detail->inward_detail_id} to status {$statusValue}");
            }
        } else {
            $model->update(['status' => $statusValue]);
            Log::info("Updated single InwardDetail ID {$model->inward_detail_id} to status {$statusValue}");
        }
    }

    // protected function setPickListDetailStatus($model, $status): void
    // {
    //     $model->update(['status' => $status]);
    // }

    protected function setPickListDetailStatus($model, $status): void
    {
        $statusValue = $this->getStatusValue($status);

        if ($this->isHeaderModel($model)) {
            foreach ($model->details as $detail) {
                $detail->update(['status' => $statusValue]);
                Log::info("Updated PickListDetail ID {$detail->picklist_detail_id} to status {$statusValue}");

                // if($statusValue == 'finalized')
                //     $this->setInwardDetailStatus($detail->inwardDetail, 'picked');
                // if($statusValue == 'cancelled')
                //     $this->setInwardDetailStatus($detail->inwardDetail, 'finalized');
            }
        } else {
            $model->update(['status' => $statusValue]);
            Log::info("Updated single PickListDetail ID {$model->picklist_detail_id} to status {$statusValue}");
            // if($statusValue == 'finalized')
            //     $this->setInwardDetailStatus($model->inwardDetail, 'picked');
            // if($statusValue == 'cancelled')
            //     $this->setInwardDetailStatus($model->inwardDetail, 'finalized');
        }

    }       

    protected function setOutwardDetailStatus($model, $status): void
    {
        $statusValue = $this->getStatusValue($status);

        if ($this->isHeaderModel($model)) {
            foreach ($model->details as $detail) {
                $detail->update(['status' => $statusValue]);
                Log::info("Updated OutwardDetail ID {$detail->outward_detail_id} to status {$statusValue}");

                if($statusValue == 'finalized') {
                    // $this->setInwardDetailStatus($detail->pickListDetail->inwardDetail, 'out');
                    $this->setPickListDetailStatus($detail->pickListDetail, 'out');
                }
                    
                if($statusValue == 'cancelled' || $statusValue == 'rejected' ) {
                    // $this->setInwardDetailStatus($detail->pickListDetail->inwardDetail, 'picked');
                    $this->setPickListDetailStatus($detail->pickListDetail, 'finalized');
                }

                if($statusValue == 'dispatched') {
                    // $this->setInwardDetailStatus($detail->pickListDetail->inwardDetail, 'dispatched');
                    $this->setPickListDetailStatus($detail->pickListDetail, 'dispatched');
                }
                    
            }
        } else {
            $model->update(['status' => $statusValue]);
            Log::info("Updated single OutwardDetail ID {$model->outward_detail_id} to status {$statusValue}");

            if($statusValue == 'finalized') {
                // $this->setInwardDetailStatus($model->pickListDetail->inwardDetail, 'out');
                $this->setPickListDetailStatus($model->pickListDetail, 'out');
            }
                
            if($statusValue == 'cancelled') {
                // $this->setInwardDetailStatus($model->pickListDetail->inwardDetail, 'picked');
                $this->setPickListDetailStatus($model->pickListDetail, 'finalized');
            }

            if($statusValue == 'dispatched' || $statusValue == 'rejected') {
                // $this->setInwardDetailStatus($model->pickListDetail->inwardDetail, 'dispatched');
                $this->setPickListDetailStatus($model->pickListDetail, 'dispatched');
            }
        }
    }
}

<?php

namespace App\ViewModels;

use App\Models\Purchase\GRNDetail;

class GrnProductViewModel
{
    public $detail;
    public $assignedQuantity;

    public function __construct(GRNDetail $detail, int $assignedQuantity = 0)
    {
        $this->detail = $detail;
        $this->assignedQuantity = $assignedQuantity;
    }

    public function isFullyAssigned(): bool
    {
        return $this->assignedQuantity >= $this->detail->box_count;
    }

    public function boxCount(): int
    {
        return $this->detail->calculated_box_count ?? 0;
    }

    public function requiredPallets(): int
    {
        return $this->detail->calculated_required_pallets ?? 0;
    }

    public function productName(): string
    {
        return $this->detail->productMaster->product_description ?? '';
    }

    public function unit(): string
    {
        return $this->detail->unit->stock_unit ?? '';
    }
}

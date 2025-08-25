<?php

namespace App\Enums;

enum StockAdjustmentReason: string
{
    case Transfer = 'Transfer';
    case Damaged = 'Damaged';
    case Missing = 'Missing';
    case Charity = 'Charity';
    case Gift = 'Gift';
    case Sample = 'Sample';
    case Rotten = 'Rotten';
    case ReceivingDiscrepancy = 'Receiving_discrepancy';
    case WeightLoss = 'Weight_loss';
    case ReceivingDamagedItems = 'Receiving_damaged_items';
    case SystemError = 'System_error';

    public function label(): string
    {
        return match($this) {
            self::Transfer => 'Transfer',
            self::Damaged => 'Damaged',
            self::Missing => 'Missing',
            self::Charity => 'Charity',
            self::Gift => 'Gift',
            self::Sample => 'Sample',
            self::Rotten => 'Rotten',
            self::ReceivingDiscrepancy => 'Receiving Discrepancy',
            self::WeightLoss => 'Weight Loss',
            self::ReceivingDamagedItems => 'Receiving Damaged Items',
            self::SystemError => 'System Error',
        };
    }
}

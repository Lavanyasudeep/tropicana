<?php
namespace App\Enums;

enum VoucherType: string
{
    case PettyCash = 'petty_cash';
    case Supplier = 'supplier';
    case Contra = 'contra';

    public function label(): string
    {
        return match ($this) {
            self::PettyCash => 'Petty Cash',
            self::Supplier => 'Supplier',
            self::Contra => 'Contra',
        };
    }
}


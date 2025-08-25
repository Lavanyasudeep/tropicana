<?php
namespace App\Enums;

enum MovementType: string
{
    case In = 'in';
    case Out = 'out';
    case Picked = 'picked';
    case Assigned = 'assigned';
    case Hold = 'hold';

    public function label(): string
    {
        return match ($this) {
            self::In => 'Inward',
            self::Out => 'Outward',
            self::Picked => 'Picked',
            self::Assigned => 'Assigned',
            self::Hold => 'On Hold',
        };
    }
}


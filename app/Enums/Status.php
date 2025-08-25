<?php

namespace App\Enums;

enum Status: string
{
    case Created = 'created';
    case Requested = 'requested';
    case Assigned = 'assigned';
    case Finalized = 'finalized';
    case Settled = 'settled';
    case In = 'in';
    case Out = 'out';
    case Picked = 'picked';
    case Hold = 'hold';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
    case Dispatched = 'dispatched';

    public function label(): string
    {
        return match ($this) {
            self::Created => 'Created',
            self::Requested => 'Requested',
            self::Assigned => 'Assigned',
            self::Finalized => 'Finalized',
            self::Settled => 'Settled',
            self::In => 'Moved to In',
            self::Out => 'Moved to Out',
            self::Picked => 'Picked',
            self::Assigned => 'Assigned',
            self::Hold => 'On Hold',
            self::Approved => 'Approve',
            self::Rejected => 'Reject',
            self::Paid => 'Paid',
            self::Cancelled => 'Cancelled',
            self::Dispatched => 'Dispatched',
        };
    }
}

<?php

namespace App\Enums;

enum Order: string
{
    case ACTIVE = 'active';
    case PAUSED = 'paused';
    case CLOSED = 'closed';
    case DELETED = 'deleted';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::PAUSED => 'Paused',
            self::CLOSED => 'Closed',
            self::DELETED => 'Deleted',
        };
    }
}

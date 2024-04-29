<?php

namespace App\Modules\Participation\Enums;

enum CommitmentLevel: string
{
    case absent = 'absent';
    case join = 'join';

    public static function collect()
    {
        return collect(self::cases());
    }
}

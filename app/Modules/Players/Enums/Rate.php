<?php

namespace App\Modules\Players\Enums;

enum Rate: string
{
    case neutral = '🙂';
    case thumbsDown = '👎';
    case thumbsUp = '👍';
    case unknown = '?';

    public static function fromNumber(int $rateNumber)
    {
        return match ($rateNumber) {
            -1 => self::thumbsDown,
            1 => self::thumbsUp,
            default => self::unknown,
        };
    }

    public static function collect()
    {
        return collect(self::cases());
    }
}

<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Role: string
{
    case ADMIN = 'admin';

    case MANAGER = 'manager';

    case EDITOR = 'editor';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}

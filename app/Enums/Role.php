<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Role: string
{
    case DEV = 'developer';
    case ADMIN = 'admin';

    case MANAGER = 'manager';

    case EDITOR = 'editor';

    case BETA = 'beta-tester';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}

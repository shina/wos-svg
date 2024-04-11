<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Language: string
{
    case english = 'en';
    case portuguese = 'pt-br';
    case french = 'fr';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}

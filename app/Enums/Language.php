<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Language: string
{
    case Chinese = 'zh';
    case Dutch = 'nl';
    case French = 'fr';
    case German = 'de';
    case Italian = 'it';
    case Korean = 'ko';
    case Lithuanian = 'lt';
    case Norwegian = 'no';
    case Polish = 'pl';
    case Portuguese = 'pt-br';
    case Russian = 'ru';
    case Turkish = 'tr';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}

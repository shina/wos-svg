<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Language: string
{
    case Portuguese = 'pt-br';
    case French = 'fr';
    case Italian = 'it';
    case Korean = 'ko';
    case Chinese = 'zh';
    case German = 'de';
    case Norwegian = 'no';
    case Lithuanian = 'lt';
    case Russian = 'ru';
    case Turkish = 'tr';
    case Dutch = 'nl';
    case Polish = 'pl';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}

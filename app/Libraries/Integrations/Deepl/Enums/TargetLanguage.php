<?php

namespace App\Libraries\Integrations\Deepl\Enums;

use App\Enums\Language;
use Illuminate\Support\Collection;

enum TargetLanguage: string
{
    case BG = 'BG';
    case CS = 'CS';
    case DA = 'DA';
    case DE = 'DE';
    case EL = 'EL';
    case EN_GB = 'EN-GB';
    case EN_US = 'EN-US';
    case ES = 'ES';
    case ET = 'ET';
    case FI = 'FI';
    case FR = 'FR';
    case HU = 'HU';
    case ID = 'ID';
    case IT = 'IT';
    case JA = 'JA';
    case KO = 'KO';
    case LT = 'LT';
    case LV = 'LV';
    case NB = 'NB';
    case NL = 'NL';
    case PL = 'PL';
    case PT_BR = 'PT-BR';
    case PT_PT = 'PT-PT';
    case RO = 'RO';
    case RU = 'RU';
    case SK = 'SK';
    case SL = 'SL';
    case SV = 'SV';
    case TR = 'TR';
    case UK = 'UK';
    case ZH = 'ZH';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }

    public static function fromLanguage(Language $language): self
    {
        return match ($language) {
            Language::zh => TargetLanguage::ZH,
            Language::nl => TargetLanguage::NL,
            Language::en => TargetLanguage::EN_GB,
            Language::fr => TargetLanguage::FR,
            Language::de => TargetLanguage::DE,
            Language::it => TargetLanguage::IT,
            Language::ko => TargetLanguage::KO,
            Language::lt => TargetLanguage::LT,
            Language::no => TargetLanguage::NB,
            Language::pl => TargetLanguage::PL,
            Language::pt => TargetLanguage::PT_BR,
            Language::ru => TargetLanguage::RU,
            Language::tr => TargetLanguage::TR,
        };
    }
}

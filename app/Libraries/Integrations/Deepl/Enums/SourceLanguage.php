<?php

namespace App\Libraries\Integrations\Deepl\Enums;

use App\Enums\Language;
use Illuminate\Support\Collection;

enum SourceLanguage: string
{
    case BG = 'BG';
    case CS = 'CS';
    case DA = 'DA';
    case DE = 'DE';
    case EL = 'EL';
    case EN = 'EN';
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
    case PT = 'PT';
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
            Language::zh => SourceLanguage::ZH,
            Language::nl => SourceLanguage::NL,
            Language::en => SourceLanguage::EN,
            Language::fr => SourceLanguage::FR,
            Language::de => SourceLanguage::DE,
            Language::it => SourceLanguage::IT,
            Language::ko => SourceLanguage::KO,
            Language::lt => SourceLanguage::LT,
            Language::no => SourceLanguage::NB,
            Language::pl => SourceLanguage::PL,
            Language::pt => SourceLanguage::PT,
            Language::ru => SourceLanguage::RU,
            Language::tr => SourceLanguage::TR,
        };
    }

    public static function toLanguage(self $sourceLanguage): Language
    {
        return match ($sourceLanguage) {
            SourceLanguage::ZH => Language::zh,
            SourceLanguage::NL => Language::nl,
            SourceLanguage::EN => Language::en,
            SourceLanguage::FR => Language::fr,
            SourceLanguage::DE => Language::de,
            SourceLanguage::IT => Language::it,
            SourceLanguage::KO => Language::ko,
            SourceLanguage::LT => Language::lt,
            SourceLanguage::NB => Language::nl,
            SourceLanguage::PL => Language::pl,
            SourceLanguage::PT => Language::pt,
            SourceLanguage::RU => Language::ru,
            SourceLanguage::TR => Language::tr,
        };
    }
}

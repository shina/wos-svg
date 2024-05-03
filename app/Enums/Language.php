<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Language
{
    case zh;
    case nl;
    case en;
    case fr;
    case de;
    case it;
    case ko;
    case lt;
    case no;
    case pl;
    case pt;
    case ru;
    case tr;
    case unknown;

    public function getEnglishLabel()
    {
        $labels = [
            'zh' => 'Chinese',
            'nl' => 'Dutch',
            'en' => 'English',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'ko' => 'Korean',
            'lt' => 'Lithuanian',
            'no' => 'Norwegian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'tr' => 'Turkish',
        ];

        return $labels[$this->name];
    }

    public function getLocalisedLabel(): string
    {
        $labels = [
            'zh' => '中文',
            'nl' => 'Nederlands',
            'en' => 'English',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'it' => 'Italiano',
            'ko' => '한국어',
            'lt' => 'Lietuvių',
            'no' => 'Norsk',
            'pl' => 'Polski',
            'pt' => 'Português',
            'ru' => 'Русский',
            'tr' => 'Türkçe',
        ];

        return $labels[$this->name];
    }

    public static function collect(): Collection
    {
        return collect(self::cases())
            ->filter(fn (self $language) => $language !== self::unknown);
    }
}

<?php

namespace App\Modules\Framework\LocaleSelection\View\Components;

use App\Enums\Language;
use Spatie\LaravelData\Data;

class LanguageOptionData extends Data
{
    public function __construct(
        public string $language,
        public string $label,
        public bool $isSelected
    ) {
    }

    public static function fromMultiple(Language $language, bool $isSelected): self
    {
        return new self(
            $language->name,
            $language->getLocalisedLabel(),
            $isSelected
        );
    }
}

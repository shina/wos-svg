<?php

namespace App\Modules\LocaleSelection\View\Components;

use App\Enums\Language;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class LocaleSelectorData extends Data
{
    public function __construct(
        public Collection $languages,
    ) {
    }

    public static function fromMultiple(Collection $languages, ?string $selected): self
    {
        return new self(
            $languages->map(function (Language $language) use ($selected) {
                return LanguageOptionData::from($language, $selected === $language->name);
            })
        );
    }
}

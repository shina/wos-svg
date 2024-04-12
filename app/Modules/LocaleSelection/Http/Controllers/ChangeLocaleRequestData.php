<?php

namespace App\Modules\LocaleSelection\Http\Controllers;

use App\Enums\Language;
use Illuminate\Validation\Rules\In;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ChangeLocaleRequestData extends Data
{
    public function __construct(
        public string $locale
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        $languages = Language::collect()->map(fn (Language $language) => $language->value);

        return [
            'locale' => [new In($languages)],
        ];
    }
}

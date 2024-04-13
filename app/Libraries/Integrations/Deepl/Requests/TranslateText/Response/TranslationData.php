<?php

namespace App\Libraries\Integrations\Deepl\Requests\TranslateText\Response;

use App\Enums\Language;
use App\Libraries\Integrations\Deepl\Enums\SourceLanguage;
use Spatie\LaravelData\Data;

class TranslationData extends Data
{
    public function __construct(
        public Language $language,
        public string $text
    ) {
    }

    public static function fromArray(array $data): static
    {
        $sourceLanguage = SourceLanguage::collect()
            ->first(fn (SourceLanguage $sourceLanguage) => $sourceLanguage->name === $data['detected_source_language']);

        return new self(
            SourceLanguage::toLanguage($sourceLanguage),
            $data['text']
        );
    }
}

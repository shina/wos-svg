<?php

namespace App\Libraries\Integrations\Deepl\Requests\TranslateText\Request;

use App\Enums\Language;
use App\Libraries\Integrations\Deepl\Enums\Formality;
use App\Libraries\Integrations\Deepl\Enums\SourceLanguage;
use App\Libraries\Integrations\Deepl\Enums\TargetLanguage;
use App\Modules\Framework\Saloon\Traits\HandlesResponse;
use Spatie\LaravelData\Data;

/**
 * @method self from(string $text, ?Language $source_lang, Language $target_lang, ?string $context = null, ?bool $preserve_formatting = null, ?Formality $formality = null)
 */
class TranslateTextData extends Data
{
    use HandlesResponse;

    public function __construct(
        public array $text,
        public ?SourceLanguage $source_lang,
        public TargetLanguage $target_lang,
        public ?string $context,
        public ?bool $preserve_formatting,
        public ?Formality $formality,
    ) {
    }

    public static function fromMultiple(
        string $text,
        Language $source_lang,
        Language $target_lang,
        ?string $context = null,
        ?bool $preserve_formatting = null,
        ?Formality $formality = null,
    ): static {
        return new self(
            [$text],
            SourceLanguage::fromLanguage($source_lang),
            TargetLanguage::fromLanguage($target_lang),
            $context,
            $preserve_formatting,
            $formality
        );
    }
}

<?php

namespace App\Libraries\Integrations\Deepl\Requests\TranslateText\Response;

use Illuminate\Support\Collection;
use Saloon\Http\Response;
use Spatie\LaravelData\Data;

/**
 * @method self from(Response $response)
 */
class ResponseData extends Data
{
    public function __construct(
        /** @var Collection<TranslationData> */
        public Collection $translations
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        return new self(
            $response->collect('translations')
                ->map(fn (array $data) => TranslationData::from($data))
        );
    }
}

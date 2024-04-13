<?php

namespace App\Libraries\Integrations\Deepl\Requests\MetaInformation;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getLanguages
 */
class GetLanguages extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/languages';
    }

    public function __construct(
        protected ?string $type = null,
    ) {
    }

    public function defaultQuery(): array
    {
        return array_filter(['type' => $this->type]);
    }
}

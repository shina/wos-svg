<?php

namespace App\Libraries\Integrations\Deepl\Requests\ManageGlossaries;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createGlossary
 */
class CreateGlossary extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/glossaries';
    }

    public function __construct()
    {
    }
}

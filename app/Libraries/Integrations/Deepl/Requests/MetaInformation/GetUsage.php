<?php

namespace App\Libraries\Integrations\Deepl\Requests\MetaInformation;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getUsage
 */
class GetUsage extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/usage';
    }

    public function __construct()
    {
    }
}

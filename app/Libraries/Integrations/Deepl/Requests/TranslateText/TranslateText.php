<?php

namespace App\Libraries\Integrations\Deepl\Requests\TranslateText;

use App\Libraries\Integrations\Deepl\Requests\TranslateText\Response\ResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * translateText
 */
class TranslateText extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/translate';
    }

    public function __construct()
    {
    }

    public function createDtoFromResponse(Response $response): ResponseData
    {
        return ResponseData::from($response);
    }
}

<?php

namespace App\Modules\Framework\Saloon;

use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Modules\Framework\Saloon\Traits\HandlesResponse;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

class ResponseHandler
{
    public function __construct(private Collection $requests)
    {
    }

    public function handle(Response $response, string|int $key): void
    {
        /** @var TranslateTextData $request */
        $request = $this->requests->get($key);

        if (objUse($request, HandlesResponse::class) === false) {
            report('Request object does not use HandlesResponse or the handler was not '.
                'registered. Skipping handling.');

            return;
        }

        $responseHandler = $request->getResponseHandler();
        $responseHandler($response->dto() ?? $response);
    }
}

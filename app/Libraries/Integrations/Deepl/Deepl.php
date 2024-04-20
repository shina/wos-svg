<?php

namespace App\Libraries\Integrations\Deepl;

use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\TranslateText;
use App\Modules\Framework\Saloon\ExceptionHandler;
use App\Modules\Framework\Saloon\ResponseHandler;
use Illuminate\Support\Collection;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

/**
 * DeepL API Documentation
 *
 * The DeepL API provides programmatic access to DeepL’s machine translation technology.
 */
class Deepl extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api-free.deepl.com/v2';
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator(config('auth.deepl.api-key'), 'DeepL-Auth-Key');
    }

    /**
     * @param  Collection<TranslateTextData>  $requests
     */
    public function bulkTranslate(Collection $requests): void
    {
        $responseHandler = new ResponseHandler($requests);
        $exceptionHandler = new ExceptionHandler($requests);

        $this
            ->pool(
                requests: $requests
                    ->map(function (TranslateTextData $requestBody) {
                        $translateTextRequest = resolve(TranslateText::class);
                        $translateTextRequest->body()->set($requestBody->toArray());

                        return $translateTextRequest;
                    })
                    ->toArray(),
                responseHandler: $responseHandler->handle(...),
                exceptionHandler: $exceptionHandler->handle(...)
            )
            ->send()
            ->wait();
    }
}

<?php

namespace App\Libraries\Integrations\Deepl;

use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Response\ResponseData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\TranslateText;
use App\Modules\Framework\Saloon\ExceptionHandler;
use App\Modules\Framework\Saloon\ResponseHandler;
use Illuminate\Support\Collection;
use Saloon\Contracts\Authenticator;
use Saloon\Exceptions\InvalidPoolItemException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
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
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function translate(TranslateTextData $translateTextData): ResponseData
    {
        $translateTextRequest = resolve(TranslateText::class);
        $translateTextRequest->body()->set($translateTextData->toArray());

        return $this->send($translateTextRequest)->dtoOrFail();
    }

    /**
     * @param  Collection<TranslateTextData>  $requests
     *
     * @throws InvalidPoolItemException
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

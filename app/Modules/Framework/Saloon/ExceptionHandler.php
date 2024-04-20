<?php

namespace App\Modules\Framework\Saloon;

use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Modules\Framework\Saloon\Traits\HandlesResponse;
use Illuminate\Support\Collection;

class ExceptionHandler
{
    public function __construct(private Collection $requests)
    {
    }

    public function handle(\Throwable $exception, string|int $key): void
    {
        /** @var TranslateTextData $request */
        $request = $this->requests->get($key);

        if (in_array(HandlesResponse::class, class_uses($request)) === false) {
            report('Request object does not use HandlesResponse or the handler was not '.
                'registered. Skipping handling.');

            return;
        }

        $exceptionHandler = $request->getExceptionHandler();
        $exceptionHandler($exception);
    }
}

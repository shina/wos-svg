Saloon and DTO framework
========================

This module focuses on using the pool functionality of Saloon and DTOs for handling request/responses

The `HandlesResponse` trait can be used by any DTO.

Then, the Handlers should be used when calling the `pool`

Example:

```php
$requests = collect([...]); // collection of request DTOs
$responseHandler = new ResponseHandler($requests);
$exceptionHandler = new ExceptionHandler($requests);

$deepl = new Deepl(); // Saloon connector

$deepl
    ->pool(
        requests: $requests
            ->map(function (TranslateTextData $requestBody) {
                $translateTextRequest = new TranslateText();
                $translateTextRequest
                    ->body()
                    ->set($requestBody->toArray());

                return $translateTextRequest;
            })
            ->toArray(),
        responseHandler: $responseHandler->handle(...),
        exceptionHandler: $exceptionHandler->handle(...)
    )
    ->send()
    ->wait();
```

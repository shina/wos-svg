<?php

namespace App\Modules\Framework\Saloon\Traits;

use Closure;

trait HandlesResponse
{
    private Closure $responseHandler;

    private Closure $exceptionHandler;

    public function handleResponseUsing(Closure $handler): self
    {
        $this->responseHandler = $handler;

        return $this;
    }

    public function getResponseHandler(): Closure
    {
        return $this->responseHandler;
    }

    public function handleExceptionUsing(Closure $exceptionHandler): self
    {
        $this->exceptionHandler = $exceptionHandler;

        return $this;
    }

    public function getExceptionHandler(): Closure
    {
        return $this->exceptionHandler;
    }
}

<?php

use App\Http\Middleware\AllianceSetupMiddleware;
use App\Modules\Framework\LocaleSelection\Http\Middleware\LocaleSelectionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->trustProxies('*')
            ->web(
                append: [
                    AllianceSetupMiddleware::class,
                    LocaleSelectionMiddleware::class,
                ]
            );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions
            ->context(resolve(\App\Modules\Framework\ExceptionHandling\Context::class)(...))
            ->render(resolve(\App\Modules\Framework\ExceptionHandling\Render::class)(...));
    })
    ->create();

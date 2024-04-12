<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->web(
                append: [
                    \App\Modules\LocaleSelection\Http\Middleware\LocaleSelectionMiddleware::class,
                ]
            );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions
            ->context(function () {
                return [
                    'request' => [
                        'params' => request()->all(),
                        'route' => request()->route()->uri,
                    ],
                ];
            })
            ->render(function (ValidationException $exception, Request $request) {
                report($exception->getMessage());

                if ($request->isJson()) {
                    return response()->json($exception->getMessage(), 404);
                }
            });
    })->create();

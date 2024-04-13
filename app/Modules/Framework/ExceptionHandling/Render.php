<?php

namespace App\Modules\Framework\ExceptionHandling;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Render
{
    public function __invoke(ValidationException $exception, Request $request)
    {
        report($exception->getMessage());

        if ($request->isJson()) {
            return response()->json($exception->getMessage(), 404);
        }
    }
}

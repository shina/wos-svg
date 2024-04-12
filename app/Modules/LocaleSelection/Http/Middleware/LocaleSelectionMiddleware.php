<?php

namespace App\Modules\LocaleSelection\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleSelectionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $locale = rescue(fn () => session()->get('user-defined-locale'));
        if ($locale !== null) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}

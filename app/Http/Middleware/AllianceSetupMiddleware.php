<?php

namespace App\Http\Middleware;

use App\Data\UrlData;
use App\Models\Alliance;
use Closure;
use Illuminate\Http\Request;

class AllianceSetupMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = UrlData::from($request->fullUrl());
        $allianceName = Alliance::query()
            ->where('domain', $url->host)
            ->limit(1)
            ->pluck('name')
            ->first();

        config()->set('app.name', $allianceName ?? config('app.name'));

        return $next($request);
    }
}

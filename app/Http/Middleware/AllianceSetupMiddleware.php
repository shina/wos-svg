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
        $alliance = Alliance::query()
            ->where('domain', $url->host)
            ->firstOr(fn () => Alliance::first());

        config()->set('app.name', $alliance->name);
        context(['alliance_id' => $alliance->id]);

        return $next($request);
    }
}
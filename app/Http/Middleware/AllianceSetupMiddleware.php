<?php

namespace App\Http\Middleware;

use App\AllianceSelector;
use App\Data\UrlData;
use App\Enums\Role;
use App\Models\Alliance;
use Closure;
use Illuminate\Http\Request;

class AllianceSetupMiddleware
{
    public function __construct(private AllianceSelector $allianceSelector) {}

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $selectedAllianceId = session('selected_alliance_id');

        if ($selectedAllianceId === null) {
            $url = UrlData::from($request->fullUrl());
            $alliance = Alliance::query()
                ->where('domain', $url->host)
                ->first();
        } else {
            $alliance = Alliance::find($selectedAllianceId);
        }

        $this->allianceSelector->select($alliance ?? Alliance::first());

        if ($user === null) {
            return $next($request);
        }

        if (! $user->hasRole(Role::DEV) && $user->cannot("access alliance-id $alliance->id")) {
            abort(403);
        }

        return $next($request);
    }
}

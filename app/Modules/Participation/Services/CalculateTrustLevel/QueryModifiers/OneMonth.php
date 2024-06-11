<?php

namespace App\Modules\Participation\Services\CalculateTrustLevel\QueryModifiers;

use App\Modules\Participation\Services\CalculateTrustLevel\QueryModifier;
use Illuminate\Database\Eloquent\Builder;

class OneMonth implements QueryModifier
{
    public function modifyQuery(Builder $query): Builder
    {
        return $query->whereHas('event', function (Builder $query) {
            $query
                ->where('date', '<', now()->subDay()->toISOString())
                ->where('date', '>', now()->subMonth()->toISOString());
        });
    }
}

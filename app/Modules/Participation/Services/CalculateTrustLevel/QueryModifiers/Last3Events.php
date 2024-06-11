<?php

namespace App\Modules\Participation\Services\CalculateTrustLevel\QueryModifiers;

use App\Modules\Participation\Services\CalculateTrustLevel\QueryModifier;
use Illuminate\Database\Eloquent\Builder;

class Last3Events implements QueryModifier
{
    public function modifyQuery(Builder $query): Builder
    {
        return $query
            ->select('attendees.*')
            ->join('events', 'events.id', '=', 'attendees.event_id')
            ->orderBy('events.date', 'desc')
            ->take(3);
    }
}

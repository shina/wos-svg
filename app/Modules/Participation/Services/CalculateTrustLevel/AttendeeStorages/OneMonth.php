<?php

namespace App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages;

use App\Modules\Participation\Attendee;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class OneMonth implements AttendeeStorage
{
    public function getAttendees(int $playerId, ?array $categoryIds): Collection
    {
        $query = Attendee::query()
            ->where('player_id', $playerId)
            ->whereHas('event', function (Builder $query) {
                $query
                    ->where('date', '<', now()->subDay()->toISOString())
                    ->where('date', '>', now()->subMonth()->toISOString());
            });

        if (filled($categoryIds)) {
            $query->whereInAllCategories($categoryIds);
        }

        return $query->get();
    }
}

<?php

namespace App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages;

use App\Modules\Participation\Attendee;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorage;
use Illuminate\Support\Collection;

class Last3Events implements AttendeeStorage
{
    public function getAttendees(int $playerId, ?array $categoryIds): Collection
    {
        $query = Attendee::query()
            ->where('player_id', $playerId)
            ->select('attendees.*')
            ->join('events', 'events.id', '=', 'attendees.event_id')
            ->where('events.date', '<', now()->setTime(0, 0)->toISOString())
            ->orderBy('events.date', 'desc')
            ->take(3);

        if (filled($categoryIds)) {
            $query->whereInAllCategories($categoryIds);
        }

        return $query->get();
    }
}

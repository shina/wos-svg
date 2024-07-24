<?php

namespace App\Modules\Participation\Services\CalculateTrustLevel;

use App\Modules\Participation\Attendee;
use Illuminate\Support\Collection;

interface AttendeeStorage
{
    /**
     * @return Collection<Attendee>
     */
    public function getAttendees(int $playerId, ?array $categoryIds): Collection;
}

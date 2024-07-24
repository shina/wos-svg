<?php

namespace App\Modules\Participation\Services;

use App\Exceptions\NonFatalException;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorage;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages\AllTime;

class CalculateTrustLevel
{
    /**
     * Retrieves the percentage of commitment for a given player.
     *
     * @param  int  $playerId  The ID of the player.
     * @return string The percentage of commitment fulfillment.
     *
     * @throws NonFatalException If the player did not commit to any event.
     */
    public function player(int $playerId, ?array $categoryIds = [], ?AttendeeStorage $attendeeStorage = null): string
    {
        if ($attendeeStorage === null) {
            $attendeeStorage = resolve(AllTime::class);
        }

        $attendees = $attendeeStorage->getAttendees($playerId, $categoryIds);

        if ($attendees->count() === 0) {
            context([__METHOD__ => get_defined_vars()]);
            throw new NonFatalException('The player did not commit to any event');
        }

        return $attendees->percentage(fn (Attendee $attendee) => $attendee->is_commitment_fulfilled);
    }
}

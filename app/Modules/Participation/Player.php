<?php

namespace App\Modules\Participation;

use App\Models\Player as BasePlayer;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends BasePlayer
{
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class)
            ->with('event')
            ->join('events', 'events.id', '=', 'attendees.event_id')
            ->orderBy('events.date', 'desc');
    }
}

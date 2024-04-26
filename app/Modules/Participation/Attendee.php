<?php

namespace App\Modules\Participation;

use App\Modules\Participation\Policies\EventPolicy;
use App\Modules\Players\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Gate;

class Attendee extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'commitment_level',
        'is_commitment_fulfilled',
        'comment',
        'player_id',
        'event_id',
    ];

    protected static function booted()
    {
        Gate::policy(self::class, EventPolicy::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}

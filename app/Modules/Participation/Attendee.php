<?php

namespace App\Modules\Participation;

use App\Models\Player;
use App\Modules\Participation\Enums\CommitmentLevel;
use App\Modules\Participation\ModelFactories\AttendeeFactory;
use App\Modules\Participation\Policies\EventPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Gate;

class Attendee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'commitment_level',
        'is_commitment_fulfilled',
        'player_id',
        'event_id',
    ];

    protected $casts = [
        'commitment_level' => CommitmentLevel::class,
        'is_commitment_fulfilled' => 'bool',
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

    protected static function newFactory()
    {
        return AttendeeFactory::new();
    }
}

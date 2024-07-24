<?php

namespace App\Modules\Participation;

use App\Modules\Participation\ModelFactories\AttendeeFactory;
use App\Modules\Participation\Policies\EventPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Gate;

class Attendee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'is_commitment_fulfilled',
        'player_id',
        'event_id',
    ];

    protected $casts = [
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

    public function playerParticipation(): HasOne
    {
        return $this->hasOne(PlayerParticipation::class, 'player_id', 'player_id');
    }

    public function scopeWhereInAllCategories(Builder $query, array $categoryIds): Builder
    {
        return $query->whereHas('event.categories', function (Builder $query) use ($categoryIds) {
            return $query->whereIn('event_categories.id', $categoryIds)
                ->groupBy('event_event_category.event_id')
                ->havingRaw('COUNT(DISTINCT event_categories.id) = ?', [count($categoryIds)]);
        });
    }

    public function scopeWhereInExactCategories(Builder $query, array $categoryIds): Builder
    {
        return $query
            ->whereHas('event.categories', function (Builder $query) use ($categoryIds) {
                return $query->whereIn('event_categories.id', $categoryIds);
            }, '=', count($categoryIds))

            ->whereHas('event.categories', function (Builder $query) use ($categoryIds) {
                return $query->groupBy('event_event_category.event_id')
                    ->havingRaw('COUNT(DISTINCT event_categories.id) = ?', [count($categoryIds)]);
            });
    }

    protected static function newFactory()
    {
        return AttendeeFactory::new();
    }
}

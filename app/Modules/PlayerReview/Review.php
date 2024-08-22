<?php

namespace App\Modules\PlayerReview;

use App\Models\Player;
use App\Models\User;
use App\Modules\PlayerReview\database\factories\ReviewFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'rating',
        'player_id',
        'reviewer_user_id'
    ];

    protected static function newFactory()
    {
        return ReviewFactory::new();
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function reviewerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function scopeActivePlayers(Builder $query): Builder
    {
        return $query->whereHas('player', function (Builder $query) {
            $query->whereNull('deleted_at');
        });
    }
}

<?php

namespace App\Modules\Participation;

use App\Traits\BelongsToAlliance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerParticipation extends Model
{
    use BelongsToAlliance;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'player_id',
        'combined_categories',
        'last_3_events',
        'one_month',
        'all_time',
    ];

    protected function casts(): array
    {
        return [
            'last_3_events' => 'float',
            'one_month' => 'float',
            'all_time' => 'float',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

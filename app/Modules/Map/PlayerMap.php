<?php

namespace App\Modules\Map;

use App\Models\Player;
use App\Traits\BelongsToAlliance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerMap extends Model
{
    use BelongsToAlliance;

    public $timestamps = false;

    protected $fillable = [
        'coordinate_position',
        'player_id',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'bool',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

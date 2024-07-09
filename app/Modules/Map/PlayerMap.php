<?php

namespace App\Modules\Map;

use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerMap extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'coordinate_position',
        'player_id',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

<?php

namespace App\Models;

use App\Modules\Players\Comment;
use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'in_game_id',
        'nickname',
        'translated_nickname',
        'rating',
        'rank',
        'background',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return PlayerFactory::new();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected function hasTranslation(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $this->translated_nickname !== null,
        );
    }

    protected function fullNickname(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => match ($this->translated_nickname === null) {
                true => $this->nickname,
                false => "$this->nickname ($this->translated_nickname)"
            }
        );
    }
}

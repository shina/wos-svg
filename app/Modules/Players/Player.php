<?php

namespace App\Modules\Players;

use App\Modules\Players\database\factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function newFactory()
    {
        return PlayerFactory::new();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}

<?php

namespace App\Modules\Players;

use App\Models\Player;
use App\Models\User;
use App\Modules\Players\database\factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return CommentFactory::new();
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function reviewerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }
}

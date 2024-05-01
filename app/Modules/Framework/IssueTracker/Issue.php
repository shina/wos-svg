<?php

namespace App\Modules\Framework\IssueTracker;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Issue extends Model
{
    protected $fillable = [
        'title',
        'description',
        'screenshots',
        'user_id',
        'solved_at',
    ];

    protected $casts = [
        'screenshots' => 'array',
        'solved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsSolvedAttribute()
    {
        return $this->solved_at !== null;
    }

    public function setIsSolvedAttribute(bool $value)
    {
        $this->solved_at = $value ? now() : null;
    }
}

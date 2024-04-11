<?php

namespace App\Modules\Notices;

use App\Modules\Notices\Policies\NoticePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Gate;

/**
 * @property Notice $notice
 */
class TranslatedNotice extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        Gate::policy(self::class, NoticePolicy::class);
    }

    protected function notice(): BelongsTo
    {
        return $this->belongsTo(Notice::class);
    }
}

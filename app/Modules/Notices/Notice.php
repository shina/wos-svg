<?php

namespace App\Modules\Notices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notice extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        self::saving(function (Notice $notice) {
            if ($notice->isDirty('title')) {
                $notice->title = strtoupper($notice->title);
            }

            if ($notice->isDirty('content')) {
                // translate into multiple languages
            }
        });
    }

    public function translatedNotices(): HasMany
    {
        return $this->hasMany(TranslatedNotice::class);
    }
}

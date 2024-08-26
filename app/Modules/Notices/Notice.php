<?php

namespace App\Modules\Notices;

use App\Modules\Notices\database\factories\NoticeFactory;
use App\Traits\BelongsToAlliance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notice extends Model
{
    use BelongsToAlliance;
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        self::saving(function (Notice $notice) {
            if ($notice->isDirty('title')) {
                $notice->title = strtoupper($notice->title);
            }
        });
    }

    protected static function newFactory()
    {
        return NoticeFactory::new();
    }

    public function translatedNotices(): HasMany
    {
        return $this->hasMany(TranslatedNotice::class);
    }
}

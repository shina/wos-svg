<?php

namespace App\Modules\Notices;

use App\Enums\Language;
use App\Modules\Notices\database\factories\TranslatedNoticeFactory;
use App\Modules\Notices\Policies\NoticePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Gate;

/**
 * @property Notice $notice
 */
class TranslatedNotice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        Gate::policy(self::class, NoticePolicy::class);
    }

    public function getLanguage(): Language
    {
        return cache()->rememberForever(
            'notices.translated-notice.language.'.$this->language,
            fn () => Language::collect()
                ->first(fn (Language $language) => $language->name === $this->language)
        );
    }

    protected function notice(): BelongsTo
    {
        return $this->belongsTo(Notice::class);
    }

    protected static function newFactory()
    {
        return TranslatedNoticeFactory::new();
    }
}

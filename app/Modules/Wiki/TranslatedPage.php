<?php

namespace App\Modules\Wiki;

use App\Enums\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslatedPage extends Model
{
    protected $guarded = [];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getLanguage(): Language
    {
        return cache()->rememberForever(
            'wiki.translated-page.language.'.$this->language,
            fn () => Language::collect()
                ->first(fn (Language $language) => $language->name === $this->language)
        );
    }
}

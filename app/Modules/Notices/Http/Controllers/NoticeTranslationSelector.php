<?php

namespace App\Modules\Notices\Http\Controllers;

use App\Modules\Notices\Notice;

class NoticeTranslationSelector
{
    public function __construct(private string $defaultLocale)
    {
    }

    /**
     * Retrieve the translated content of a notice based on the specified locale.
     *
     * @param  Notice  $notice  The notice object to retrieve the translated content from.
     * @param  string  $locale  The locale to retrieve the translated content for.
     * @return string The translated content of the notice if available, otherwise the default content.
     */
    public function getTranslatedContent(Notice $notice, string $locale): string
    {
        if ($locale === $this->defaultLocale) {
            return $notice->content;
        }

        $translatedNotice = $notice->translatedNotices()
            ->where('language', $locale)
            ->first();

        return $translatedNotice->content ?? $notice->content;
    }
}

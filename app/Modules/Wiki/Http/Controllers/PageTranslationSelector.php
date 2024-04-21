<?php

namespace App\Modules\Wiki\Http\Controllers;

use App\Modules\Wiki\Page;

/**
 * todo how to make a general class for every model that needs translation?
 */
class PageTranslationSelector
{
    public function __construct(private string $defaultLocale)
    {
    }

    /**
     * Retrieve the translated content of a page based on the specified locale.
     *
     * @param  Page  $page  The page object to retrieve the translated content from.
     * @param  string  $locale  The locale to retrieve the translated content for.
     * @return string The translated content of the page if available, otherwise the default content.
     */
    public function getTranslatedContent(Page $page, string $locale): string
    {
        if ($locale === $this->defaultLocale) {
            return $page->content;
        }

        $translatedPage = $page->translatedPages()
            ->where('language', $locale)
            ->first();

        return $translatedPage->content ?? $page->content;
    }
}

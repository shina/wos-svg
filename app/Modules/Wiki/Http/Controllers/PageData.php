<?php

namespace App\Modules\Wiki\Http\Controllers;

use App\Modules\Wiki\Data\Transformers\MarkdownTransformer;
use App\Modules\Wiki\Page;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

class PageData extends Data
{
    public function __construct(
        #[WithTransformer(MarkdownTransformer::class)]
        public string $content,
    ) {
    }

    public static function fromPage(Page $page): static
    {
        $pageTranslationSelector = resolve(PageTranslationSelector::class);
        $locale = app()->getLocale();

        return new self($pageTranslationSelector->getTranslatedContent($page, $locale));
    }
}

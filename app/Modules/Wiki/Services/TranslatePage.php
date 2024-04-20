<?php

namespace App\Modules\Wiki\Services;

use App\Enums\Language;
use App\Libraries\Integrations\Deepl\Deepl;
use App\Libraries\Integrations\Deepl\Enums\Formality;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Response\ResponseData;
use App\Modules\Notices\Notice;
use App\Modules\Wiki\Page;
use App\Modules\Wiki\TranslatedPage;

class TranslatePage
{
    public function __construct(private Deepl $deepl)
    {
    }

    /**
     * Executes the auto translation process for a given Page.
     *
     * @param  Page  $page  The Notice instance to be translated.
     */
    public function __invoke(Page $page): void
    {
        $translateTextRequests = $page->translatedPages
            ->filter(fn (TranslatedPage $translatedPage) => $translatedPage->enable_auto_translation)
            ->map(fn (TranslatedPage $translatedPage) => $this->makeTranslatedTextData($page, $translatedPage));

        $this->deepl->bulkTranslate($translateTextRequests);
    }

    public function singleTranslation(TranslatedPage $translatedPage): void
    {
        $translateTextData = $this->makeTranslatedTextData($translatedPage->page, $translatedPage);
        $this->deepl->bulkTranslate(
            collect([$translateTextData])
        );
    }

    private function makeTranslatedTextData(Page $page, TranslatedPage $translatedPage): TranslateTextData
    {
        $translateTextData = TranslateTextData::from(
            $page->content,
            Language::en,
            $translatedPage->getLanguage(),
            null, null, Formality::prefer_less
        );

        $translateTextData->handleResponseUsing(function (ResponseData $response) use ($translatedPage) {
            $translatedPage->content = $response->translations->first()->text;
            $translatedPage->save();
        });

        $translateTextData->handleExceptionUsing(report(...));

        return $translateTextData;
    }
}

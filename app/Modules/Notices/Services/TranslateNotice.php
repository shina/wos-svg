<?php

namespace App\Modules\Notices\Services;

use App\Enums\Language;
use App\Libraries\Integrations\Deepl\Deepl;
use App\Libraries\Integrations\Deepl\Enums\Formality;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Response\ResponseData;
use App\Modules\Notices\Notice;
use App\Modules\Notices\TranslatedNotice;

class TranslateNotice
{
    public function __construct(private Deepl $deepl)
    {
    }

    /**
     * Executes the auto translation process for a given Notice.
     *
     * @param  Notice  $notice  The Notice instance to be translated.
     */
    public function __invoke(Notice $notice): void
    {
        $translateTextRequests = $notice->translatedNotices
            ->filter(fn (TranslatedNotice $translatedNotice) => $translatedNotice->enable_auto_translation)
            ->map(function (TranslatedNotice $translatedNotice) use ($notice) {
                $translateTextData = TranslateTextData::from(
                    $notice->content,
                    Language::en,
                    $translatedNotice->getLanguage(),
                    null, null, Formality::prefer_less
                );

                $translateTextData->handleResponseUsing(function (ResponseData $response) use ($translatedNotice) {
                    $translatedNotice->content = $response->translations->first()->text;
                    $translatedNotice->save();
                });

                $translateTextData->handleExceptionUsing(report(...));

                return $translateTextData;
            });

        $this->deepl->bulkTranslate($translateTextRequests);
    }
}

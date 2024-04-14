<?php

namespace App\Modules\Notices\Services;

use App\Enums\Language;
use App\Libraries\Integrations\Deepl\Deepl;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\RequestBodyData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Response\ResponseData;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\TranslateText;
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
        $notice->translatedNotices
            ?->filter(fn (TranslatedNotice $translatedNotice) => $translatedNotice->enable_auto_translation)
            ->each(function (TranslatedNotice $translatedNotice) use ($notice) {
                $language = Language::collect()
                    ->first(fn (Language $language) => $language->name === $translatedNotice->language);

                $translatedNotice->content = $this->translate($notice, $language);

                $translatedNotice->save();
            });
    }

    private function translate(Notice $notice, Language $language): string
    {
        $request = resolve(TranslateText::class);
        $request->body()->set(
            RequestBodyData::from($notice->content, Language::en, $language)->toArray()
        );

        $response = $this->deepl->send($request);

        if ($response->failed()) {
            $response->throw();
        }

        return ResponseData::from($response)
            ->translations
            ->first()
            ->text;
    }
}

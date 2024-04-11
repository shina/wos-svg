<?php

use App\Modules\Notices\Http\Controllers\NoticeTranslationSelector;
use App\Modules\Notices\Notice;
use App\Modules\Notices\TranslatedNotice;

describe('getTranslatedContent', function () {
    test('when using a TranslatedNotice', function () {
        $notice = Notice::factory()->create();
        /** @var TranslatedNotice $translatedNotice */
        $translatedNotice = TranslatedNotice::factory(10)
            ->create(['notice_id' => $notice->id])
            ->random(1)
            ->first();

        $result = resolve(NoticeTranslationSelector::class)
            ->getTranslatedContent($notice, $translatedNotice->language);

        expect($result)->toBe($translatedNotice->content);
    });

    test('when using default locale', function () {
        $notice = Notice::factory()->create();
        TranslatedNotice::factory(10)
            ->create(['notice_id' => $notice->id]);

        $noticeTranslationSelector = new NoticeTranslationSelector('en');
        $result = $noticeTranslationSelector->getTranslatedContent($notice, 'en');

        expect($result)->toBe($notice->content);
    });

    test('when locale does not exist', function () {
        $notice = Notice::factory()->create();
        TranslatedNotice::factory()
            ->create([
                'language' => 'pt',
                'notice_id' => $notice->id,
            ]);

        $result = resolve(NoticeTranslationSelector::class)
            ->getTranslatedContent($notice, 'invalid-locale');

        expect($result)->toBe($notice->content);
    });
});

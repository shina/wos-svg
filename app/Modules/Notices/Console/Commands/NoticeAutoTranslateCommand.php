<?php

namespace App\Modules\Notices\Console\Commands;

use App\Enums\Language;
use App\Modules\Notices\Notice;
use App\Modules\Notices\Services\TranslateNotice;
use App\Modules\Notices\TranslatedNotice;
use Illuminate\Console\Command;

class NoticeAutoTranslateCommand extends Command
{
    protected $signature = 'notice:auto-translate';

    protected $description = 'This command automatically translates all notices in the application.';

    public function handle(TranslateNotice $translateNotice): void
    {
        Notice::all()->each(function (Notice $notice) use ($translateNotice) {
            $noticeLanguages = $notice->translatedNotices
                ?->map(fn (TranslatedNotice $translateNotice) => $translateNotice->language);

            Language::collect()
                ->map(fn (Language $language) => $language->name)
                ->except('en')
                ->diff($noticeLanguages)
                ->each(function (string $language) use ($notice) {
                    return $notice->translatedNotices()
                        ->create(['language' => $language, 'enable_auto_translation' => true]);
                });
            $notice->unsetRelations();

            $translateNotice($notice);
        });
    }
}

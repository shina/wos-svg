<?php

namespace App\Modules\Notices\Console\Commands;

use App\Enums\Language;
use App\Modules\Notices\Notice;
use App\Modules\Notices\Services\TranslateNotice;
use App\Modules\Notices\TranslatedNotice;
use Illuminate\Console\Command;

class NoticeAutoTranslateCommand extends Command
{
    protected $signature = 'notice:auto-translate {--id= : The id to be translated} {--all : Translate all notices}';

    protected $description = 'This command automatically translates all notices in the application.';

    public function handle(TranslateNotice $translateNotice): void
    {
        $id = $this->option('id');
        $isAll = $this->option('all');

        $notices = $isAll ? Notice::all() : collect([Notice::find($id)]);

        $notices->each(function (Notice $notice) use ($translateNotice) {
            $noticeLanguages = $notice->translatedNotices
                ?->map(fn (TranslatedNotice $translateNotice) => $translateNotice->getLanguage()->name);

            Language::collect()
                ->map(fn (Language $language) => $language->name)
                ->filter(fn (string $lang) => $lang !== 'en')
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

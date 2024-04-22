<?php

namespace App\Modules\Wiki\Console\Commands;

use App\Enums\Language;
use App\Modules\Wiki\Page;
use App\Modules\Wiki\Services\TranslatePage;
use App\Modules\Wiki\TranslatedPage;
use Illuminate\Console\Command;

class PageAutoTranslateCommand extends Command
{
    protected $signature = 'page:auto-translate {--id= : The id to be translated} {--all : Translate all pages}';

    protected $description = 'This command automatically translates all pages in the application.';

    public function handle(TranslatePage $translatePage): void
    {
        $id = $this->option('id');
        $isAll = $this->option('all');

        $pages = $isAll ? Page::all() : collect([Page::find($id)]);

        $pages->each(function (Page $page) use ($translatePage) {
            $pageLanguages = $page->translatedPages
                ->map(fn (TranslatedPage $translatedPage) => $translatedPage->getLanguage()->name);

            Language::collect()
                ->map(fn (Language $language) => $language->name)
                ->filter(fn (string $lang) => $lang !== 'en')
                ->diff($pageLanguages)
                ->each(function (string $language) use ($page) {
                    return $page->translatedPages()
                        ->create(['language' => $language, 'enable_auto_translation' => true]);
                });
            $page->unsetRelations();

            $translatePage($page);
        });
    }
}

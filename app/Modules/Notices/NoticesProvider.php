<?php

namespace App\Modules\Notices;

use App\Modules\Notices\Console\Commands\NoticeAutoTranslateCommand;
use App\Modules\Notices\Http\Controllers\NoticeTranslationSelector;
use Illuminate\Support\ServiceProvider;

class NoticesProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(NoticeTranslationSelector::class, function () {
            return new NoticeTranslationSelector(app()->getFallbackLocale());
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'notices');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->commands([
            NoticeAutoTranslateCommand::class,
        ]);
    }
}

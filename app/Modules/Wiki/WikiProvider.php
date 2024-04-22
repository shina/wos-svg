<?php

namespace App\Modules\Wiki;

use App\Modules\Wiki\Console\Commands\PageAutoTranslateCommand;
use App\Modules\Wiki\Http\Controllers\PageTranslationSelector;
use Illuminate\Support\ServiceProvider;

class WikiProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PageTranslationSelector::class, function () {
            return new PageTranslationSelector(app()->getFallbackLocale());
        });
    }

    public function boot(): void
    {
        $this->commands([
            PageAutoTranslateCommand::class,
        ]);
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wiki');
    }
}

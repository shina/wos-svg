<?php

namespace App\Modules\Framework\LocaleSelection;

use App\Modules\Framework\LocaleSelection\View\Components\LocaleSelector;
use Illuminate\Support\ServiceProvider;

class LocaleSelectionProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'locale-selection');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'locale-selection');
        $this->loadViewComponentsAs('locale-selection', [
            'selector' => LocaleSelector::class,
        ]);
    }
}

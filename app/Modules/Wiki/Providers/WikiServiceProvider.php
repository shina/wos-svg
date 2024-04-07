<?php

namespace App\Modules\Wiki\Providers;

use Illuminate\Support\ServiceProvider;

class WikiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(app_path('Modules/Wiki/routes.php'));
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wiki');
    }

    public function boot(): void
    {
    }
}

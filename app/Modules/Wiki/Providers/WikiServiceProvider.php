<?php

namespace App\Modules\Wiki\Providers;

use Illuminate\Support\ServiceProvider;

class WikiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wiki');
        $this->loadRoutesFrom(app_path('Modules/Wiki/routes.php'));
    }
}

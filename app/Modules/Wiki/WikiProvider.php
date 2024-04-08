<?php

namespace App\Modules\Wiki;

use Illuminate\Support\ServiceProvider;

class WikiProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wiki');
    }
}

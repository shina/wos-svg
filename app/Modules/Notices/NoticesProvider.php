<?php

namespace App\Modules\Notices;

use Illuminate\Support\ServiceProvider;

class NoticesProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'notices');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}

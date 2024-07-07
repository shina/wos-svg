<?php

namespace App\Modules\Map;

use Illuminate\Support\ServiceProvider;

class MapProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'map');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}

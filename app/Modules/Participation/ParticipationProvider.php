<?php

namespace App\Modules\Participation;

use Illuminate\Support\ServiceProvider;

class ParticipationProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'participation');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'participation');
    }
}

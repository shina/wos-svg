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
    }
}

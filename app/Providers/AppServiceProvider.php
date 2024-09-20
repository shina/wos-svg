<?php

namespace App\Providers;

use App\Libraries\Integrations\Deepl\Deepl;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegistrationResponse::class, fn () => new \App\Http\Responses\RegistrationResponse);

        $this->app->bind(Deepl::class, fn () => new Deepl(config('auth.deepl.api-key')));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

use App\Modules\Wiki\Http\Controllers\PageController;
use App\Modules\Wiki\Services\RouteSlugsRegex;
use Illuminate\Support\Facades\Route;

if (config('app.env') === 'testing') {
    return;
}

$routeSlugsRegex = resolve(RouteSlugsRegex::class);

Route::get('/{slug}', PageController::class)
    ->where('slug', $routeSlugsRegex->get());

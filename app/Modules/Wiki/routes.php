<?php

use App\Modules\Wiki\Http\Controllers\PageController;
use App\Modules\Wiki\Services\RouteSlugsRegex;
use Illuminate\Support\Facades\Route;

$routeSlugsRegex = resolve(RouteSlugsRegex::class);

Route::get('/{slug}', PageController::class)
    ->where('slug', $routeSlugsRegex->get());

<?php

use App\Modules\Wiki\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/{slug}', PageController::class)
    ->where('slug', '^(?!.*\bup\b).*');

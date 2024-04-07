<?php

use Illuminate\Support\Facades\Route;

Route::get('/{slug}', \App\Modules\Wiki\Http\Controllers\PageController::class);

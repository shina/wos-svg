<?php

use App\Modules\Map\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/map', MapController::class);

<?php

use App\Modules\Map\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->get('/map', MapController::class);

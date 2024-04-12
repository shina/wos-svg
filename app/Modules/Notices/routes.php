<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->get('/notices', \App\Modules\Notices\Http\Controllers\ListNoticesController::class);

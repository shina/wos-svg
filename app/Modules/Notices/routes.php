<?php

use Illuminate\Support\Facades\Route;

Route::get('/notices', \App\Modules\Notices\Http\Controllers\ListNoticesController::class);

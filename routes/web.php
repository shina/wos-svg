<?php

use Illuminate\Support\Facades\Route;

Route::get('/notices', 'App\Http\Controllers\ListNoticesController');
Route::get('/map', 'App\Http\Controllers\BearTrapMapController');

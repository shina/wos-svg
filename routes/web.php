<?php

use Illuminate\Support\Facades\Route;

Route::get('/notices', 'App\Http\Controllers\ListNoticesController');
Route::get('/{slug}', 'App\Http\Controllers\CustomPageController');

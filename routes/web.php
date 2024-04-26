<?php

use App\Modules\Wiki\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/{slug}', PageController::class);

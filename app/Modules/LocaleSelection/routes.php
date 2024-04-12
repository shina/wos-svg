<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->get('/locale-selection/api/change', App\Modules\LocaleSelection\Http\Controllers\ChangeLocaleController::class);

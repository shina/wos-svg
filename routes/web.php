<?php

use App\Models\Alliance;
use App\Modules\Wiki\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $alliance = Alliance::find(allianceId());

    return view('welcome', ['alliance' => $alliance]);
});

Route::get('/{slug}', PageController::class);

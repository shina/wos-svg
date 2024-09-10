<?php

use App\Models\Alliance;
use App\Modules\Wiki\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $alliance = Alliance::find(allianceId());

    return view('welcome', ['alliance' => $alliance]);
});

Route::get(
    '/new-user-welcome',
    fn () => 'Successfully registered, ping one of the admins so they can approve your registration'
)->name('new-user-welcome');

Route::get('/{slug}', PageController::class);

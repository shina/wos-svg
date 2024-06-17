<?php

use App\Modules\Participation\Http\Controllers\TriggerCalculationController;
use Illuminate\Support\Facades\Route;

Route::get('participation/recalculate/{secret}', TriggerCalculationController::class);

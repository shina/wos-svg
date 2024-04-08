<?php

use App\Modules\Wiki\Http\Controllers\PageController;

Route::get('/{slug}', PageController::class);

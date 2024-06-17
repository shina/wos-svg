<?php

namespace App\Modules\Participation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Participation\Jobs\RecalculateAllPlayersJob;
use Illuminate\Http\Request;

class TriggerCalculationController extends Controller
{
    public function __invoke(Request $request)
    {
        $secret = config('participation.secret');
        if ($request->route('secret') !== $secret) {
            abort(403, 'You are not authorized to access this resource.');
        }

        RecalculateAllPlayersJob::dispatch();
    }
}

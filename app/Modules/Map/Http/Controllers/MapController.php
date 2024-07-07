<?php

namespace App\Modules\Map\Http\Controllers;

use App\Http\Controllers\Controller;

class MapController extends Controller
{
    public function __invoke()
    {
        return view('map::map');
    }
}

<?php

namespace App\Http\Controllers;

class BearTrapMapController extends Controller
{
    public function __invoke()
    {
        return view('bear-trap-map');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notice;

class ListNoticesController extends Controller
{
    public function __invoke()
    {
        return view('list-notices', [
            'notices' => Notice::query()
                ->orderBy('priority', 'desc')
                ->get()
        ]);
    }
}

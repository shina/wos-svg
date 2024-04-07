<?php

namespace App\Modules\Notices\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notices\Models\Notice;

class ListNoticesController extends Controller
{
    public function __invoke()
    {
        return view('notices::list-notices', [
            'notices' => Notice::query()
                ->orderBy('priority', 'desc')
                ->get()
        ]);
    }
}

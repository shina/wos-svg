<?php

namespace App\Modules\Notices\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notices\Notice;

class ListNoticesController extends Controller
{
    public function __invoke()
    {
        return view('notices::list-notices', ListNoticesData::from(
            Notice::query()
                ->orderBy('priority', 'asc')
                ->get()
        ));
    }
}

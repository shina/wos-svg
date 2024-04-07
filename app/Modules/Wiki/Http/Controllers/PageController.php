<?php

namespace App\Modules\Wiki\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wiki\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __invoke(Request $request)
    {
        $slug = $request->route('slug');
        $page = Page::query()
            ->where('slug', $slug)
            ->first();

        abort_if($page === null, 404);

        return view('wiki::page', PageData::from($page));
    }
}

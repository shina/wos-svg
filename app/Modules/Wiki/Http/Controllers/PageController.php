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
        $customPage = Page::query()
            ->where('slug', $slug)
            ->first();

        abort_if($customPage === null, 404);

        $parsedown = new \Parsedown();

        return view('wiki::page', [
            'content' => $parsedown->text($customPage->content),
        ]);
    }
}

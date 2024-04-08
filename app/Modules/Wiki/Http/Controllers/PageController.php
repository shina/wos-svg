<?php

namespace App\Modules\Wiki\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wiki\Repositories\PageRepository;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(private PageRepository $pageRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $slug = $request->route('slug');
        $page = $this->pageRepository->getBySlug($slug);

        abort_if($page === null, 404);

        return view('wiki::page', PageData::from($page));
    }
}

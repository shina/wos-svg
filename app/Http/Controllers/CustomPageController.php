<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomPageController extends Controller
{
    public function __invoke(Request $request)
    {
        $slug = $request->route('slug');
        $customPage = CustomPage::query()
            ->where('slug', $slug)
            ->first();

        abort_if($customPage === null, 404);

        $parsedown = new \Parsedown();
        return view('custom-page', [
            'content' => $parsedown->text($customPage->content)
        ]);
    }
}

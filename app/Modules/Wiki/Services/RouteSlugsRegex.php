<?php

namespace App\Modules\Wiki\Services;

use App\Modules\Wiki\Models\Page;

class RouteSlugsRegex
{
    public function get(): string
    {
        return Page::query()
            ->get(['slug'])
            ->pluck('slug')
            ->join('|');
    }
}

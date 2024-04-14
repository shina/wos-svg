<?php

namespace App\Modules\Wiki\Repositories;

use App\Modules\Wiki\Page;
use App\Traits\FakeableTrait;

class PageRepository
{
    use FakeableTrait;

    /**
     * @return ?Page
     */
    public function getBySlug(string $slug): ?Page
    {
        return Page::query()
            ->where('slug', $slug)
            ->first();
    }
}

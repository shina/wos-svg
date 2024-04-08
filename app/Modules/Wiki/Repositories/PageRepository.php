<?php

namespace App\Modules\Wiki\Repositories;

use App\Modules\Wiki\Models\Page;
use App\Traits\FakeableTrait;
use Illuminate\Support\Collection;

class PageRepository
{
    use FakeableTrait;

    /**
     * @return Collection<string>
     */
    public function getAllSlugs(): Collection
    {
        return Page::query()
            ->get(['slug'])
            ->pluck('slug');
    }
}

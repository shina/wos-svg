<?php

namespace App\Modules\Wiki\Services;

use App\Modules\Wiki\Repositories\PageRepository;

class RouteSlugsRegex
{
    public function __construct(private PageRepository $pageRepository)
    {
    }

    public function get(): string
    {
        return cache()->rememberForever(
            self::class,
            function () {
                return $this->pageRepository->getAllSlugs()->join('|');
            }
        );
    }

    public function flushCache()
    {
        cache()->forget(self::class);
    }
}

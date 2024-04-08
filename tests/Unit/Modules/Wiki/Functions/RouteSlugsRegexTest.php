<?php

namespace Tests\Modules\Wiki\Functions;

use App\Modules\Wiki\Models\Page;
use App\Modules\Wiki\Services\RouteSlugsRegex;

describe('RouteSlugsRegex', function () {
    beforeEach(function () {
        $this->routeSlugsRegex = resolve(RouteSlugsRegex::class);
    });

    it('should return a string', function () {
        $pages = Page::factory(3)->create();

        $result = $this->routeSlugsRegex->get();

        expect($result)
            ->toContain(
                $pages[0]->slug,
                $pages[1]->slug,
                $pages[2]->slug
            );
    });
});

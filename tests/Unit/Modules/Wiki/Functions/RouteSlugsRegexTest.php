<?php

namespace Tests\Modules\Wiki\Functions;

use App\Modules\Wiki\Models\Page;
use App\Modules\Wiki\Repositories\PageRepository;
use App\Modules\Wiki\Services\RouteSlugsRegex;

describe('RouteSlugsRegex', function () {
    it('should return a string', function () {
        PageRepository::fake(['getAllSlugs' => collect(['foo', 'bar', 'baz'])]);

        $routeSlugsRegex = resolve(RouteSlugsRegex::class);
        $result = $routeSlugsRegex->get();

        expect($result)
            ->toContain(
                'foo',
                'bar',
                'baz'
            );
    });

    it('should cache the result', function () {
        $pageRepository = PageRepository::fake(['getAllSlugs' => collect(['foo'])]);

        $routeSlugsRegex = new RouteSlugsRegex($pageRepository);
        $routeSlugsRegex->get();
        $routeSlugsRegex->get();
        $routeSlugsRegex->get();
        $routeSlugsRegex->get();

        $pageRepository
            ->shouldHaveReceived('getAllSlugs')
            ->once();
    });

    it('should forget cache', function () {
        $pageRepository = PageRepository::fake(['getAllSlugs' => collect(['foo'])]);

        $routeSlugsRegex = new RouteSlugsRegex($pageRepository);
        $routeSlugsRegex->get();
        expect(cache()->get(RouteSlugsRegex::class))
            ->not()
            ->toBeEmpty();

        $routeSlugsRegex->flushCache();
        expect(cache()->get(RouteSlugsRegex::class))
            ->toBeEmpty();
    });

    it('should refresh when a page is created/updated', function () {
        $pageRepository = PageRepository::fake(['getAllSlugs' => collect(['foo'])]);

        $routeSlugsRegex = new RouteSlugsRegex($pageRepository);

        $routeSlugsRegex->get();
        Page::factory()->create();
        $routeSlugsRegex->get();

        $pageRepository
            ->shouldHaveReceived('getAllSlugs')
            ->times(2);
    });
});

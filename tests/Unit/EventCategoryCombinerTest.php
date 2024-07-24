<?php

namespace Tests\Modules\Participation\Services;

use App\Modules\Participation\Services\EventCategoryCombiner;

describe('EventCategoryCombiner', function () {
    it('should work with a single category', function () {
        $result = resolve(EventCategoryCombiner::class)->combineCategoriesArray([1]);

        expect($result)->toBe([
            [1],
        ]);
    });

    it('should combine when 2 categories', function () {
        $result = resolve(EventCategoryCombiner::class)
            ->combineCategoriesArray([1, 2]);

        expect($result)->toBe([
            [1],
            [2],
            [1, 2],
        ]);
    });

    it('should combine when 3 categories', function () {
        $result = resolve(EventCategoryCombiner::class)
            ->combineCategoriesArray([1, 2, 3]);

        expect($result)->toBe([
            [1],
            [2],
            [3],
            [1, 2],
            [1, 3],
            [2, 3],
            [1, 2, 3],
        ]);
    });

    it('should handle data set', function () {
        $result = resolve(EventCategoryCombiner::class)
            ->combineCategoriesArray([]);

        expect($result)->toBe([]);
    });

    it('should combine using string separator', function () {
        $result = resolve(EventCategoryCombiner::class)
            ->combineCategoriesString([1, 2, 3], '|');

        expect($result)->toBe([
            '1',
            '2',
            '3',
            '1|2',
            '1|3',
            '2|3',
            '1|2|3',
        ]);
    });
});

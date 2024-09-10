<?php

namespace Tests;

use App\AllianceSelector;
use App\Models\Alliance;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app()->bind(AllianceSelector::class, function () {
            return new class
            {
                public function select(Alliance $alliance)
                {
                    //
                }

                public function getSelected(): int
                {
                    return 1;
                }
            };
        });
    }
}

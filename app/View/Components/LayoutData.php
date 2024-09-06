<?php

namespace App\View\Components;

use Spatie\LaravelData\Data;

class LayoutData extends Data
{
    public function __construct(
        public string $acronym,
        public LogoData $logo
    ) {}
}

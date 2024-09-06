<?php

namespace App\View\Components;

use Spatie\LaravelData\Data;

class LogoData extends Data
{
    public function __construct(
        public string $large,
        public string $medium,
        public string $small,
    ) {}
}

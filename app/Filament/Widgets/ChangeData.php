<?php

namespace App\Filament\Widgets;

use Spatie\LaravelData\Data;

class ChangeData extends Data
{
    public function __construct(
        public bool $isNew,
        public string $title,
        public ?string $description,
        public string $date
    ) {
    }
}

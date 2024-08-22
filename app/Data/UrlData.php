<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class UrlData extends Data
{
    public function __construct(
        public ?string $schema,
        public ?string $host,
        public ?int $port,
        public ?string $user,
        public ?string $pass,
        public ?string $path,
        public ?string $query,
        public ?string $fragment,
    ) {}

    public static function fromString(string $url): static
    {
        return self::from(parse_url($url));
    }
}

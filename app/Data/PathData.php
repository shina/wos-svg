<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PathData extends Data
{
    public function __construct(
        public string $dirname,
        public string $basename,
        public ?string $extension,
        public string $filename,
    ) {}

    public static function fromString(string $path): static
    {
        return self::from(pathinfo($path));
    }

    public function toString(): string
    {
        $fullPath = $this->dirname.DIRECTORY_SEPARATOR.$this->filename;

        if (isset($this->extension)) {
            $fullPath .= '.'.$this->extension;
        }

        return $fullPath;
    }
}

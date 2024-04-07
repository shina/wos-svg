<?php

namespace App\Modules\Wiki\Http\Controllers;

use App\Modules\Wiki\Data\Transformers\MarkdownTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

class PageData extends Data
{

    public function __construct(
        #[WithTransformer(MarkdownTransformer::class)]
        public string $content,
    ) {}

}

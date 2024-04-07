<?php

namespace App\Modules\Wiki\Data\Transformers;

use Parsedown;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class MarkdownTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed
    {
        $parsedown = app(Parsedown::class);
        return $parsedown->text($value);
    }
}

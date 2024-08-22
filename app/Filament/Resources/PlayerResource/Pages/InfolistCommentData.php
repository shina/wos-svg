<?php

namespace App\Filament\Resources\PlayerResource\Pages;

use App\Modules\PlayerReview\Enums\Rate;
use App\Modules\PlayerReview\Review;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class InfolistCommentData extends Data
{
    public function __construct(
        public string $player,
        public string $commentBy,
        public string $comment,
        public Rate $rate,
        public Carbon $when
    ) {}

    public static function fromComment(Review $comment): static
    {
        return new static(
            $comment->player->nickname,
            $comment->reviewerUser->name,
            $comment->content,
            Rate::fromNumber($comment->rating),
            $comment->created_at
        );
    }
}

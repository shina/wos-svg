<?php

namespace App\Modules\PlayerReview\Services;

use App\Models\Player;
use App\Modules\PlayerReview\Review;

class RatingCalculator
{
    /**
     * Calculate the total rating for a player based on their reviews.
     *
     * @param  Player  $player  The player for whom to calculate the rating.
     * @return int The total rating for the player.
     *
     * @throws \Throwable
     */
    public function calculate(Player $player): int
    {
        return $player->reviews
            ->map(fn (Review $review) => $review->rating)
            ->reduce(function (int $result, int $rating) {
                $newValue = $result + $rating;

                if ($newValue > 10) {
                    return 10;
                }

                if ($newValue < 0) {
                    return 0;
                }

                return $newValue;
            }, 10);
    }
}

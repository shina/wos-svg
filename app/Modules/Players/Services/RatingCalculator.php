<?php

namespace App\Modules\Players\Services;

use App\Modules\Players\Comment;
use App\Modules\Players\Player;

class RatingCalculator
{
    /**
     * Calculate the total rating for a player based on their comments.
     *
     * @param  Player  $player  The player for whom to calculate the rating.
     * @return int The total rating for the player.
     *
     * @throws \Throwable
     */
    public function calculate(Player $player): int
    {
        return $player->comments
            ->map(fn (Comment $comment) => $comment->rating)
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

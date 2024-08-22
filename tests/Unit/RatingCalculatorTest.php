<?php

use App\Models\Player;
use App\Modules\PlayerReview\Review;

describe('RatingCalculator', function () {
    it('should calculate adding or subtracting from the initial 10', function () {
        $player = Player::factory()->create();
        $comments = Review::factory(5)
            ->create([
                'player_id' => $player->id,
            ]);
        $comments[0]->rating = 1;
        $comments[1]->rating = -1;
        $comments[2]->rating = -1;
        $comments[3]->rating = -1;
        $comments[4]->rating = 1;
        $comments->each(fn (Review $comment) => $comment->save());

        $ratingCalculator = new \App\Modules\PlayerReview\Services\RatingCalculator;
        $result = $ratingCalculator->calculate($player);

        expect($result)->toBe(8);
    });
});

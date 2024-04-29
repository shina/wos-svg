<?php

use App\Models\Player;
use App\Modules\Players\Comment;

describe('RatingCalculator', function () {
    it('should calculate adding or subtracting from the initial 10', function () {
        $player = Player::factory()->create();
        $comments = Comment::factory(5)
            ->create([
                'player_id' => $player->id,
            ]);
        $comments[0]->rating = 1;
        $comments[1]->rating = -1;
        $comments[2]->rating = -1;
        $comments[3]->rating = -1;
        $comments[4]->rating = 1;
        $comments->each(fn (Comment $comment) => $comment->save());

        $ratingCalculator = new \App\Modules\Players\Services\RatingCalculator();
        $result = $ratingCalculator->calculate($player);

        expect($result)->toBe(8);
    });
});

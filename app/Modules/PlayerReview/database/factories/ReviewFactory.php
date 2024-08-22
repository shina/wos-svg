<?php

namespace App\Modules\PlayerReview\database\factories;

use App\Models\Player;
use App\Models\User;
use App\Modules\PlayerReview\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->words(5, true),
            'rating' => $this->faker->randomElement([-1, 1]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'player_id' => Player::factory(),
            'reviewer_user_id' => User::factory(),
        ];
    }
}

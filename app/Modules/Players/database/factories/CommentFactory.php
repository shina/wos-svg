<?php

namespace App\Modules\Players\database\factories;

use App\Models\User;
use App\Modules\Players\Comment;
use App\Modules\Players\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

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

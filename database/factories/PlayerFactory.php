<?php

namespace Database\Factories;

use App\Models\Alliance;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'nickname' => $this->faker->word(),
            'rating' => $this->faker->numberBetween(0, 10),
            'in_game_id' => (string) $this->faker->unique()->randomNumber(),
            'rank' => $this->faker->numberBetween(1, 5),
            'background' => $this->faker->words(10, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'alliance_id' => Alliance::factory()->create()->id,
        ];
    }
}

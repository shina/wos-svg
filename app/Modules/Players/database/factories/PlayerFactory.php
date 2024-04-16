<?php

namespace App\Modules\Players\database\factories;

use App\Modules\Players\Player;
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
            'in_game_id' => (string) $this->faker->randomNumber(),
            'rank' => $this->faker->numberBetween(1, 5),
            'background' => $this->faker->words(10, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

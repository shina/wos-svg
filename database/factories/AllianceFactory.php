<?php

namespace Database\Factories;

use App\Models\Alliance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AllianceFactory extends Factory
{
    protected $model = Alliance::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name(),
            'acronym' => $this->faker->unique()->word(),
            'state' => $this->faker->randomNumber(),
            'domain' => $this->faker->unique()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

<?php

namespace App\Modules\Participation\ModelFactories;

use App\Modules\Participation\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'date' => $this->faker->date(),
        ];
    }
}

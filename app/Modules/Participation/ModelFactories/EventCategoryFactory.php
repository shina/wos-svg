<?php

namespace App\Modules\Participation\ModelFactories;

use App\Modules\Participation\EventCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventCategoryFactory extends Factory
{
    protected $model = EventCategory::class;

    public function definition(): array
    {
        return [
            'category' => $this->faker->word(),
        ];
    }
}

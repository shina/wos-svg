<?php

namespace App\Modules\Participation\ModelFactories;

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendeeFactory extends Factory
{
    protected $model = Attendee::class;

    public function definition(): array
    {
        return [
            'is_commitment_fulfilled' => $this->faker->boolean(),
            'player_id' => Player::factory()->create()->id,
            'event_id' => Event::factory()->create()->id,
        ];
    }
}

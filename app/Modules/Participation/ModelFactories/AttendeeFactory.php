<?php

namespace App\Modules\Participation\ModelFactories;

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Enums\CommitmentLevel;
use App\Modules\Participation\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendeeFactory extends Factory
{
    protected $model = Attendee::class;

    public function definition(): array
    {
        return [
            'commitment_level' => $this->faker->randomElement(CommitmentLevel::collect()),
            'is_commitment_fulfilled' => $this->faker->boolean(),
            'comment' => $this->faker->realText(),
            'player_id' => Player::factory()->create()->id,
            'event_id' => Event::factory()->create()->id,
        ];
    }
}

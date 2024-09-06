<?php

namespace App\Modules\Notices\database\factories;

use App\Models\Alliance;
use App\Modules\Notices\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->words(10, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'priority' => $this->faker->randomNumber(),

            'alliance_id' => Alliance::factory(),
        ];
    }
}

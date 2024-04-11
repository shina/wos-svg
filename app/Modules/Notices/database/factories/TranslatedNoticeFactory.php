<?php

namespace App\Modules\Notices\database\factories;

use App\Modules\Notices\Notice;
use App\Modules\Notices\TranslatedNotice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TranslatedNoticeFactory extends Factory
{
    protected $model = TranslatedNotice::class;

    public function definition(): array
    {
        return [
            'language' => $this->faker->languageCode(),
            'content' => $this->faker->words(10, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'notice_id' => Notice::factory(),
        ];
    }
}

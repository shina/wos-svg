<?php

namespace App\Modules\Participation\Jobs;

use App\Modules\Participation\PlayerParticipation;
use App\Modules\Participation\Services\CalculateTrustLevel;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages\Last3Events;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages\OneMonth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculatePlayerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $playerId,
        private readonly ?array $categoryIds,
        private readonly int $allianceId
    ) {}

    public function handle(CalculateTrustLevel $calculateTrustLevel): void
    {
        $combinedCategoriesString = $this->categoryIds === null ? null : implode('-', $this->categoryIds);

        $playerParticipation = PlayerParticipation::query()
            ->where('player_id', $this->playerId)
            ->where('combined_categories', $combinedCategoriesString)
            ->firstOrNew();

        $playerParticipation->player_id = $this->playerId;
        $playerParticipation->combined_categories = $combinedCategoriesString;
        $playerParticipation->alliance_id = $this->allianceId;
        $playerParticipation->all_time = rescue(
            fn () => (float) $calculateTrustLevel->player($this->playerId, $this->categoryIds),
            report: false
        );
        $playerParticipation->one_month = rescue(
            fn () => (float) $calculateTrustLevel->player($this->playerId, $this->categoryIds, new OneMonth),
            report: false
        );
        $playerParticipation->last_3_events = rescue(
            fn () => (float) $calculateTrustLevel->player($this->playerId, $this->categoryIds, new Last3Events),
            report: false
        );

        $playerParticipation->save();
    }
}

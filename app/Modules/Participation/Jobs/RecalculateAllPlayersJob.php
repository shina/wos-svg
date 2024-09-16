<?php

namespace App\Modules\Participation\Jobs;

use App\Models\Player;
use App\Modules\Participation\EventCategory;
use App\Modules\Participation\PlayerParticipation;
use App\Modules\Participation\Services\EventCategoryCombiner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateAllPlayersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $allianceId) {}

    public function handle(EventCategoryCombiner $eventCategoryCombiner): void
    {
        PlayerParticipation::query()
            ->where('alliance_id', $this->allianceId)
            ->delete();

        $categoryIds = EventCategory::query()
            ->where('alliance_id', $this->allianceId)
            ->orderBy('id')
            ->pluck('id')
            ->toArray();
        $combinedCategoriesArray = collect(
            $eventCategoryCombiner->combineCategoriesArray($categoryIds)
        );

        Player::query()
            ->where('alliance_id', $this->allianceId)
            ->each(function (Player $player) use ($combinedCategoriesArray) {
                $combinedCategoriesArray->each(fn (array $categoryIds) => dispatch_sync(
                    new RecalculatePlayerJob($player->id, $categoryIds, $this->allianceId)
                ));

                dispatch_sync(new RecalculatePlayerJob($player->id, null, $this->allianceId));
            });

        $this->processDeletedPlayers();
    }

    private function processDeletedPlayers(): void
    {
        $deletedPlayerIds = Player::query()
            ->onlyTrashed()
            ->pluck('id')
            ->toArray();
        PlayerParticipation::query()
            ->whereIn('player_id', $deletedPlayerIds)
            ->delete();
    }
}

<?php

namespace App\Modules\Participation\Jobs;

use App\Models\Player;
use App\Modules\Participation\PlayerParticipation;
use App\Modules\Participation\Services\CalculateTrustLevel;
use App\Modules\Participation\Services\CalculateTrustLevel\QueryModifiers\Last3Events;
use App\Modules\Participation\Services\CalculateTrustLevel\QueryModifiers\OneMonth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateAllPlayersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(CalculateTrustLevel $calculateTrustLevel): void
    {
        Player::each(function (Player $player) use ($calculateTrustLevel) {
            $participation = PlayerParticipation::query()
                ->where('player_id', $player->id)
                ->firstOrCreate(['player_id' => $player->id]);

            $participation->all_time = rescue(fn () => (float) $calculateTrustLevel->player($player->id), null, false);
            $participation->one_month = rescue(fn () => (float) $calculateTrustLevel->player($player->id, new OneMonth()), null, false);
            $participation->last_3_events = rescue(fn () => (float) $calculateTrustLevel->player($player->id, new Last3Events()), null, false);
            $participation->save();
        });

        $deletedPlayerIds = Player::query()
            ->onlyTrashed()
            ->pluck('id')
            ->toArray();
        PlayerParticipation::query()
            ->whereIn('player_id', $deletedPlayerIds)
            ->delete();
    }
}

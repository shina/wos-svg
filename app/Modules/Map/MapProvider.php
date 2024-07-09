<?php

namespace App\Modules\Map;

use App\Models\Player;
use Illuminate\Support\ServiceProvider;

class MapProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'map');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        Player::deleted(fn (Player $player) => PlayerMap::query()
            ->where('player_id', $player->id)
            ->delete());
    }
}

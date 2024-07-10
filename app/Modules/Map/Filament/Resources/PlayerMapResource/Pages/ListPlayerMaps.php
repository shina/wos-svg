<?php

namespace App\Modules\Map\Filament\Resources\PlayerMapResource\Pages;

use App\Models\Player;
use App\Modules\Map\Filament\Resources\PlayerMapResource;
use App\Modules\Map\PlayerMap;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPlayerMaps extends ListRecords
{
    protected static string $resource = PlayerMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Open map')
                ->url('/map-test')
                ->link()
                ->openUrlInNewTab(),
            Action::make('Select on map')
                ->url(ListPlayerMapsOnMap::getUrl()),
            Action::make('Add remaining players')
                ->action(function () {
                    $existingPlayers = PlayerMap::query()
                        ->select('player_id')
                        ->pluck('player_id')
                        ->toArray();

                    Player::query()
                        ->whereNotIn('id', $existingPlayers)
                        ->each(fn (Player $player) => PlayerMap::create(['player_id' => $player->id, 'coordinate_position' => 1]));
                }),
        ];
    }
}

<?php

namespace App\Modules\Map\Filament\Resources\PlayerMapResource\Pages;

use App\Modules\Map\Enums\Coordinate;
use App\Modules\Map\Filament\Resources\PlayerMapResource;
use App\Modules\Map\PlayerMap;
use App\Modules\Map\resources\views\components\GridItemData;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;

class ListPlayerMapsOnMap extends Page
{
    protected static string $resource = PlayerMapResource::class;

    protected static string $view = 'map::filament.pages.list-player-maps-on-map';

    protected static ?string $title = 'Map';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Go back')
                ->url(ListPlayerMaps::getUrl()),
        ];
    }

    public function getData()
    {
        $existingGridItems = PlayerMap::query()
            ->with('player')
            ->where('coordinate_position', '>=', 1)
            ->where('coordinate_position', '<=', 100)
            ->get()
            ->mapWithKeys(function (PlayerMap $playerMap) {
                $gridItem = GridItemData::from($playerMap);
                $gridItem->url = EditPlayerMap::getUrl(['record' => $playerMap->id]);

                return [$playerMap->coordinate_position => $gridItem];
            });

        return collect(range(1, 100))
            ->mapWithKeys(function (int $position) {
                $gridItem = GridItemData::from(Coordinate::{'P'.$position});
                $gridItem->url = CreatePlayerMap::getUrl(['position' => $position]);

                return [$position => $gridItem];
            })
            ->replace($existingGridItems);
    }
}

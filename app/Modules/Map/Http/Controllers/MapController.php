<?php

namespace App\Modules\Map\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Map\PlayerMap;
use App\Modules\Map\resources\views\components\GridItemData;

class MapController extends Controller
{
    public function __invoke()
    {
        $gridItems = PlayerMap::query()
            ->with('player')
            ->where('coordinate_position', '>=', 1)
            ->where('coordinate_position', '<=', 126)
            ->get()
            ->map(fn (PlayerMap $playerMap) => GridItemData::from($playerMap));

        return view('map::map', ['items' => $gridItems]);
    }
}

<?php

namespace App\Modules\Map\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Map\PlayerMap;

class MapController extends Controller
{
    public function __invoke()
    {
        $gridItems = PlayerMap::query()
            ->with('player')
            ->where('coordinate_position', '<', 99)
            ->get()
            ->map(fn (PlayerMap $playerMap) => GridItemData::from($playerMap));

        return view('map::map', ['items' => $gridItems]);
    }
}

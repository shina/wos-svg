<?php

namespace App\Modules\Map\Http\Controllers;

use App\Modules\Map\Enums\Coordinate;
use App\Modules\Map\PlayerMap;
use Spatie\LaravelData\Data;

class GridItemData extends Data
{
    public function __construct(
        public string $nickname,
        public string $row,
        public string $col
    ) {
    }

    public static function fromPlayerMap(PlayerMap $playerMap): static
    {
        $coordinate = Coordinate::{'P'.$playerMap->coordinate_position};
        [$row, $col] = explode('x', $coordinate->value);

        return new static($playerMap->player->full_nickname, $row, $col);
    }
}

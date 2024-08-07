<?php

namespace App\Modules\Map\resources\views\components;

use App\Modules\Map\Enums\Coordinate;
use App\Modules\Map\PlayerMap;
use Spatie\LaravelData\Data;

class GridItemData extends Data
{
    private static array $colors = [
        'wrong' => 'red',
        'correct' => '#5C9B3E',
        'empty' => 'grey',
    ];

    public function __construct(
        public string $nickname,
        public string $row,
        public string $col,
        public string $color,
        public ?string $url = null
    ) {
    }

    public static function fromPlayerMap(PlayerMap $playerMap): static
    {
        $coordinate = Coordinate::{'P'.$playerMap->coordinate_position};
        [$row, $col] = explode('x', $coordinate->value);

        $color = $playerMap->is_correct ? self::$colors['correct'] : self::$colors['wrong'];

        return new static($playerMap->player->nickname, $row, $col, $color);
    }

    public static function fromCoordinate(Coordinate $coordinate)
    {
        [$row, $col] = explode('x', $coordinate->value);

        return new static('-', $row, $col, self::$colors['empty']);
    }
}

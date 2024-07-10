<?php

namespace App\Modules\Map\Enums;

use Illuminate\Support\Collection;

enum Coordinate: string
{
    // Position = Coordinates

    // 1st ring
    case P1 = '11x7';
    case P2 = '11x9';
    case P3 = '11x11';
    case P4 = '11x13';
    case P5 = '13x13';
    case P6 = '15x13';
    case P7 = '17x13';
    case P8 = '17x11';
    case P9 = '17x9';
    case P10 = '17x7';
    case P11 = '15x7';
    case P12 = '13x7';

    // 2nd ring
    case P13 = '9x7';
    case P14 = '9x9';
    case P15 = '9x11';
    case P16 = '9x13';
    case P17 = '9x15';
    case P18 = '11x15';
    case P19 = '13x15';
    case P20 = '15x15';
    case P21 = '17x15';
    case P22 = '19x15';
    case P23 = '19x13';
    case P24 = '19x11';
    case P25 = '19x9';
    case P26 = '19x7';
    case P27 = '19x5';
    case P28 = '17x5';
    case P29 = '15x5';
    case P30 = '13x5';
    case P31 = '11x5';
    case P32 = '7x5';
    case P33 = '7x7';
    case P34 = '7x9';
    case P35 = '7x11';
    case P36 = '7x13';
    case P37 = '7x15';
    case P38 = '11x17';
    case P39 = '13x17';
    case P40 = '15x17';
    case P41 = '17x17';
    case P42 = '19x17';
    case P43 = '21x17';
    case P44 = '21x15';
    case P45 = '21x13';
    case P46 = '21x11';
    case P47 = '21x9';
    case P48 = '21x7';
    case P49 = '21x5';
    case P50 = '21x3';
    case P51 = '19x3';
    case P52 = '17x3';
    case P53 = '15x3';
    case P54 = '13x3';
    case P55 = '11x3';
    case P56 = '9x3';
    case P57 = '7x3';
    case P58 = '5x3';
    case P59 = '5x5';
    case P60 = '5x7';
    case P61 = '5x9';
    case P62 = '5x13';
    case P63 = '5x15';
    case P64 = '5x17';
    case P65 = '5x19';
    case P66 = '7x19';
    case P67 = '11x19';
    case P68 = '13x19';
    case P69 = '17x19';
    case P70 = '19x19';
    case P71 = '21x19';
    case P72 = '23x19';
    case P73 = '23x17';
    case P74 = '23x14';
    case P75 = '23x10';
    case P76 = '23x7';
    case P77 = '23x5';
    case P78 = '23x3';
    case P79 = '19x1';
    case P80 = '17x1';
    case P81 = '13x1';
    case P82 = '11x1';
    case P83 = '9x1';
    case P84 = '7x1';
    case P85 = '3x7';
    case P86 = '3x9';
    case P87 = '3x11';
    case P88 = '3x13';
    case P89 = '3x15';
    case P90 = '11x21';
    case P91 = '13x21';
    case P92 = '15x21';
    case P93 = '17x21';
    case P94 = '19x21';
    case P95 = '25x7';
    case P96 = '25x9';
    case P97 = '25x11';
    case P98 = '25x13';
    case P99 = '25x15';
    case P100 = '25x17';

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}

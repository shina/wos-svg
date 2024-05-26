<?php

namespace App\Filament\Resources\PlayerResource\Table\Columns;

use Filament\Tables\Columns\TextColumn;

class InGameIdColumn extends TextColumn
{
    public static function make(string $name = 'in_game_id'): static
    {
        return parent::make($name)
            ->label('')
            ->prefix('#')
            ->size(TextColumn\TextColumnSize::ExtraSmall)
            ->width(1)
            ->searchable();
    }
}

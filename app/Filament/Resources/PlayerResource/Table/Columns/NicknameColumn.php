<?php

namespace App\Filament\Resources\PlayerResource\Table\Columns;

use App\Models\Player;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class NicknameColumn extends TextColumn
{
    public static function make(string $name = 'nickname'): static
    {
        return parent::make($name)
            ->searchable(query: function (Builder $query, string $search) {
                return $query
                    ->where('nickname', 'like', "%{$search}%")
                    ->orWhere('translated_nickname', 'like', "%{$search}%");
            })
            ->label('')
            ->formatStateUsing(fn (Player $record) => $record->full_nickname);
    }
}

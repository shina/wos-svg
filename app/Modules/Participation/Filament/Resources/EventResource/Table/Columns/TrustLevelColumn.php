<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Table\Columns;

use App\Models\Player;
use App\Modules\Participation\Services\CalculateTrustLevel;
use App\Modules\Participation\Services\CalculateTrustLevel\QueryModifiers\Last3Events;
use App\Modules\Participation\Services\CalculateTrustLevel\QueryModifiers\OneMonth;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;

class TrustLevelColumn
{
    /**
     * Creates a new TextColumn instance for the trust-level column.
     *
     * @param  callable  $getPlayerId  A callable function that receive the $record as argument and returns the player ID.
     * @return TextColumn The TextColumn instance for the trust-level column.
     */
    public static function make(callable $getPlayerId)
    {
        return ColumnGroup::make('Participation rate')
            ->columns([
                TextColumn::make('last-3-events')
                    ->state(function (CalculateTrustLevel $calculateTrustLevel, $record) use ($getPlayerId) {
                        return rescue(
                            fn () => $calculateTrustLevel->player($getPlayerId($record), new Last3Events()),
                            'never attended',
                            false
                        );
                    })
                    ->suffix(fn (string $state) => $state === 'never attended' ? '' : '%'),
                TextColumn::make('1-month')
                    ->state(function (CalculateTrustLevel $calculateTrustLevel, $record) use ($getPlayerId) {
                        return rescue(
                            fn () => $calculateTrustLevel->player($getPlayerId($record), new OneMonth()),
                            'never attended',
                            false
                        );
                    })
                    ->suffix(fn (string $state) => $state === 'never attended' ? '' : '%'),
                TextColumn::make('all-time')
                    ->state(function (CalculateTrustLevel $calculateTrustLevel, $record) use ($getPlayerId) {
                        return rescue(
                            fn () => $calculateTrustLevel->player($getPlayerId($record)),
                            'never attended',
                            false
                        );
                    })
                    ->suffix(fn (string $state) => $state === 'never attended' ? '' : '%'),
            ]);
    }
}

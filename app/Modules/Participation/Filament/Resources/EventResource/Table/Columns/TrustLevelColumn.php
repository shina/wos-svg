<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Table\Columns;

use App\Models\Player;
use App\Modules\Participation\Services\CalculateTrustLevel;
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
        return TextColumn::make('trust-level')
            ->state(function (CalculateTrustLevel $calculateTrustLevel, $record) use ($getPlayerId) {
                return rescue(
                    fn () => $calculateTrustLevel->player($getPlayerId($record)),
                    'never attended',
                    false
                );
            })
            ->suffix(fn (string $state) => $state === 'never attended' ? '' : '%');
    }
}

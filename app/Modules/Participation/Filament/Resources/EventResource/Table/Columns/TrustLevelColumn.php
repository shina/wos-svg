<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Table\Columns;

use App\Models\Player;
use App\Modules\Participation\PlayerParticipation;
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
    public static function make(callable $getPlayerParticipation)
    {
        return ColumnGroup::make('Participation rate')
            ->columns([
                TextColumn::make('last-3-events')
                    ->state(function ($record) use ($getPlayerParticipation) {
                        /** @var PlayerParticipation $participation */
                        $participation = $getPlayerParticipation($record);

                        return isset($participation->last_3_events) ? "$participation->last_3_events%" : 'never attended';
                    }),
                TextColumn::make('1-month')
                    ->state(function ($record) use ($getPlayerParticipation) {
                        /** @var PlayerParticipation $participation */
                        $participation = $getPlayerParticipation($record);

                        return isset($participation->one_month) ? "$participation->one_month%" : 'never attended';
                    }),
                TextColumn::make('all-time')
                    ->state(function ($record) use ($getPlayerParticipation) {
                        /** @var PlayerParticipation $participation */
                        $participation = $getPlayerParticipation($record);

                        return isset($participation->all_time) ? "$participation->all_time%" : 'never attended';
                    }),
            ]);
    }
}

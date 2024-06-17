<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Table\Columns;

use App\Models\Player;
use App\Modules\Participation\PlayerParticipation;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class TrustLevelColumn
{
    /**
     * Creates a new TextColumn instance for the trust-level column.
     *
     * @param  callable  $getPlayerParticipation  A callable function that receive the $record as argument and returns the player ID.
     * @return TextColumn The TextColumn instance for the trust-level column.
     */
    public static function make(callable $getPlayerParticipation, string $joinTablePlayerId) // not happy with this solution ($joinTablePlayerId)
    {
        return ColumnGroup::make('Participation rate')
            ->columns([
                TextColumn::make('last-3-events')
                    ->state(function ($record) use ($getPlayerParticipation) {
                        /** @var PlayerParticipation $participation */
                        $participation = $getPlayerParticipation($record);

                        return isset($participation->last_3_events) ? "$participation->last_3_events%" : 'never attended';
                    })
                    ->sortable(true, function (Builder $query, string $direction) use ($joinTablePlayerId) {
                        return $query
                            ->join('player_participations', 'player_participations.player_id', '=', $joinTablePlayerId)
                            ->orderBy('player_participations.last_3_events', $direction);
                    }),
                TextColumn::make('1-month')
                    ->state(function ($record) use ($getPlayerParticipation) {
                        /** @var PlayerParticipation $participation */
                        $participation = $getPlayerParticipation($record);

                        return isset($participation->one_month) ? "$participation->one_month%" : 'never attended';
                    })
                    ->sortable(true, function (Builder $query, string $direction) use ($joinTablePlayerId) {
                        return $query
                            ->join('player_participations', 'player_participations.player_id', '=', $joinTablePlayerId)
                            ->orderBy('player_participations.one_month', $direction);
                    }),
                TextColumn::make('all-time')
                    ->state(function ($record) use ($getPlayerParticipation) {
                        /** @var PlayerParticipation $participation */
                        $participation = $getPlayerParticipation($record);

                        return isset($participation->all_time) ? "$participation->all_time%" : 'never attended';
                    })
                    ->sortable(true, function (Builder $query, string $direction) use ($joinTablePlayerId) {
                        return $query
                            ->join('player_participations', 'player_participations.player_id', '=', $joinTablePlayerId)
                            ->orderBy('player_participations.all_time', $direction);
                    }),
            ]);
    }
}

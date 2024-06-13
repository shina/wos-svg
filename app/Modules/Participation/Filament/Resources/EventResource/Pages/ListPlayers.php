<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\PlayerResource;
use App\Filament\Resources\PlayerResource\Table\Columns\InGameIdColumn;
use App\Filament\Resources\PlayerResource\Table\Columns\NicknameColumn;
use App\Models\Player;
use App\Modules\Participation\Filament\Resources\EventResource\Table\Columns\TrustLevelColumn;
use App\Modules\Participation\PlayerParticipation;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected static ?string $title = 'Players Participation';

    public function getTable(): Table
    {
        return parent::getTable()
            ->columns([
                InGameIdColumn::make(),
                NicknameColumn::make(),
                TrustLevelColumn::make(
                    fn (Player $record) => PlayerParticipation::query()->where('player_id', $record->id)->first()
                ),
            ])
            ->recordUrl(null)
            ->actions([]);
    }
}

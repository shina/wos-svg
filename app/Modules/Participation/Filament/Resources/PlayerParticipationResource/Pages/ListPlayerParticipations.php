<?php

namespace App\Modules\Participation\Filament\Resources\PlayerParticipationResource\Pages;

use App\Modules\Participation\Filament\Resources\PlayerParticipationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlayerParticipations extends ListRecords
{
    protected static string $resource = PlayerParticipationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\CreateAction::make(),
        ];
    }
}

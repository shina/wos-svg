<?php

namespace App\Modules\Players\Filament\Resources\PlayerResource\Pages;

use App\Modules\Players\Filament\Resources\PlayerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

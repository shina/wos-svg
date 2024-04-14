<?php

namespace App\Modules\Players\Filament\Resources\PlayerResource\Pages;

use App\Modules\Players\Filament\Resources\PlayerResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlayer extends CreateRecord
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

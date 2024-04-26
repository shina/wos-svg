<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Pages;

use App\Modules\Participation\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

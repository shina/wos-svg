<?php

namespace App\Modules\Participation\Filament\Resources\EventCategoryResource\Pages;

use App\Modules\Participation\Filament\Resources\EventCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventCategory extends CreateRecord
{
    protected static string $resource = EventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

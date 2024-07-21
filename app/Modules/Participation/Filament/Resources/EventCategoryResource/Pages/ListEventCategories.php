<?php

namespace App\Modules\Participation\Filament\Resources\EventCategoryResource\Pages;

use App\Modules\Participation\Filament\Resources\EventCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventCategories extends ListRecords
{
    protected static string $resource = EventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

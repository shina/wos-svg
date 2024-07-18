<?php

namespace App\Modules\Participation\Filament\Resources\EventCategoryResource\Pages;

use App\Modules\Participation\Filament\Resources\EventCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventCategory extends EditRecord
{
    protected static string $resource = EventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

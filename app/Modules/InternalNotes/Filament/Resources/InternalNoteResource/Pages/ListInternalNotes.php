<?php

namespace App\Modules\InternalNotes\Filament\Resources\InternalNoteResource\Pages;

use App\Modules\InternalNotes\Filament\Resources\InternalNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternalNotes extends ListRecords
{
    protected static string $resource = InternalNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

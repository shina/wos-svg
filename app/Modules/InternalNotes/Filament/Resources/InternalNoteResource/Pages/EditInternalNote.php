<?php

namespace App\Modules\InternalNotes\Filament\Resources\InternalNoteResource\Pages;

use App\Modules\InternalNotes\Filament\Resources\InternalNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternalNote extends EditRecord
{
    protected static string $resource = InternalNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

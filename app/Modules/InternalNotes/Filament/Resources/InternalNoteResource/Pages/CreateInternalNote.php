<?php

namespace App\Modules\InternalNotes\Filament\Resources\InternalNoteResource\Pages;

use App\Modules\InternalNotes\Filament\Resources\InternalNoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInternalNote extends CreateRecord
{
    protected static string $resource = InternalNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

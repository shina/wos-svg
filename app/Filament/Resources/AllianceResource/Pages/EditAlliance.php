<?php

namespace App\Filament\Resources\AllianceResource\Pages;

use App\Filament\Resources\AllianceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAlliance extends EditRecord
{
    protected static string $resource = AllianceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

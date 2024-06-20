<?php

namespace App\Modules\Agreement\Filament\Resources\AgreementResource\Pages;

use App\Modules\Agreement\Filament\Resources\AgreementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAgreement extends EditRecord
{
    protected static string $resource = AgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

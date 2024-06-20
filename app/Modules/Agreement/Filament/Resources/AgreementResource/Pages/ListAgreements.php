<?php

namespace App\Modules\Agreement\Filament\Resources\AgreementResource\Pages;

use App\Modules\Agreement\Filament\Resources\AgreementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgreements extends ListRecords
{
    protected static string $resource = AgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

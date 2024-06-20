<?php

namespace App\Modules\Agreement\Filament\Resources\AgreementResource\Pages;

use App\Modules\Agreement\Filament\Resources\AgreementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAgreement extends CreateRecord
{
    protected static string $resource = AgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

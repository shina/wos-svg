<?php

namespace App\Filament\Resources\CustomPageResource\Pages;

use App\Filament\Resources\CustomPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomPage extends CreateRecord
{
    protected static string $resource = CustomPageResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

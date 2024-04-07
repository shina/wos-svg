<?php

namespace App\Modules\Wiki\Filament\Resources\PageResource\Pages;

use App\Modules\Wiki\Filament\Resources\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

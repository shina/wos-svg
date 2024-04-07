<?php

namespace App\Modules\Wiki\Filament\Resources\PageResource\Pages;

use App\Modules\Wiki\Filament\Resources\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

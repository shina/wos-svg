<?php

namespace App\Modules\Wiki\Filament\Resources\PageResource\Pages;

use App\Modules\Wiki\Filament\Resources\PageResource;
use App\Modules\Wiki\Services\TranslatePage;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    public function afterCreate()
    {
        $translatePage = resolve(TranslatePage::class);
        $translatePage($this->record);
    }
}

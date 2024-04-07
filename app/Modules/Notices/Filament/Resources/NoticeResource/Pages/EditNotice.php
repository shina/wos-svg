<?php

namespace App\Modules\Notices\Filament\Resources\NoticeResource\Pages;

use App\Modules\Notices\Filament\Resources\NoticeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNotice extends EditRecord
{
    protected static string $resource = NoticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

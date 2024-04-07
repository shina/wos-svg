<?php

namespace App\Modules\Notices\Filament\Resources\NoticeResource\Pages;

use App\Modules\Notices\Filament\Resources\NoticeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNotices extends ListRecords
{
    protected static string $resource = NoticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

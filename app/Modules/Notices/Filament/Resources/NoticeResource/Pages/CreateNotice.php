<?php

namespace App\Modules\Notices\Filament\Resources\NoticeResource\Pages;

use App\Modules\Notices\Filament\Resources\NoticeResource;
use App\Modules\Notices\Services\TranslateNotice;
use Filament\Resources\Pages\CreateRecord;

class CreateNotice extends CreateRecord
{
    protected static string $resource = NoticeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    public function afterCreate()
    {
        $translateNotice = resolve(TranslateNotice::class);
        $translateNotice($this->record);
    }
}

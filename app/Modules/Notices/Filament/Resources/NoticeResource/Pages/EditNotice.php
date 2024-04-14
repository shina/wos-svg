<?php

namespace App\Modules\Notices\Filament\Resources\NoticeResource\Pages;

use App\Modules\Notices\Filament\Resources\NoticeResource;
use App\Modules\Notices\Notice;
use App\Modules\Notices\Services\TranslateNotice;
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

    public function beforeSave()
    {
        Notice::saving(function (Notice $notice) {
            if ($notice->isDirty('content')) {
                $translateNotice = resolve(TranslateNotice::class);
                $translateNotice($notice);
            }
        });
    }
}

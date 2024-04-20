<?php

namespace App\Modules\Wiki\Filament\Resources\PageResource\Pages;

use App\Modules\Wiki\Filament\Resources\PageResource;
use App\Modules\Wiki\Page;
use App\Modules\Wiki\Services\TranslatePage;
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

    public function beforeSave()
    {
        Page::saving(function (Page $page) {
            if ($page->isDirty('content')) {
                $translatePage = resolve(TranslatePage::class);
                $translatePage($page);
            }
        });
    }
}

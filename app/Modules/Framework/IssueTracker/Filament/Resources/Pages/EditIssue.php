<?php

namespace App\Modules\Framework\IssueTracker\Filament\Resources\Pages;

use App\Modules\Framework\IssueTracker\Filament\Resources\IssueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIssue extends EditRecord
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

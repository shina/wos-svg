<?php

namespace App\Modules\Framework\IssueTracker\Filament\Resources\Pages;

use App\Modules\Framework\IssueTracker\Filament\Resources\IssueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIssue extends CreateRecord
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

<?php

namespace App\Modules\Framework\IssueTracker\Filament\Resources\Pages;

use App\Modules\Framework\IssueTracker\Filament\Resources\IssueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIssues extends ListRecords
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

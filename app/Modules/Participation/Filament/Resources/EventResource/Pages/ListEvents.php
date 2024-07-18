<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\Pages;

use App\Modules\Participation\Filament\Resources\EventCategoryResource\Pages\ListEventCategories;
use App\Modules\Participation\Filament\Resources\EventResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('config')
                ->icon('heroicon-s-adjustments-horizontal')
                ->hiddenLabel()
                ->link()
                ->url(ListEventCategories::getUrl()),
        ];
    }
}

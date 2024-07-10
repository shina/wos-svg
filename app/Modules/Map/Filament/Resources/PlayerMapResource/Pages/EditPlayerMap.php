<?php

namespace App\Modules\Map\Filament\Resources\PlayerMapResource\Pages;

use App\Modules\Map\Filament\Resources\PlayerMapResource;
use App\Modules\Map\PlayerMap;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditPlayerMap extends EditRecord
{
    protected static string $resource = PlayerMapResource::class;

    protected static ?string $title = 'Edit Position';

    public function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('coordinate_position')
                ->required(),

            Select::make('player_id')
                ->required()
                ->relationship('player', 'nickname')
                ->searchable(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function beforeSave()
    {
        PlayerMap::query()
            ->where('player_id', $this->data['player_id'])
            ->delete();
    }

    protected function getRedirectUrl(): ?string
    {
        return ListPlayerMapsOnMap::getUrl();
    }
}

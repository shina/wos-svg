<?php

namespace App\Modules\Map\Filament\Resources\PlayerMapResource\Pages;

use App\Modules\Map\Filament\Resources\PlayerMapResource;
use App\Modules\Map\PlayerMap;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreatePlayerMap extends CreateRecord
{
    protected static string $resource = PlayerMapResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Assign Position';

    public function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('coordinate_position')
                ->required()
                ->default(request()->route('position')),

            Select::make('player_id')
                ->required()
                ->relationship('player', 'nickname')
                ->searchable(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function beforeCreate()
    {
        PlayerMap::query()
            ->where('player_id', $this->data['player_id'])
            ->delete();
    }

    protected function getRedirectUrl(): string
    {
        return ListPlayerMapsOnMap::getUrl();
    }
}

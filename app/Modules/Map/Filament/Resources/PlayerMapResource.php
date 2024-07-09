<?php

namespace App\Modules\Map\Filament\Resources;

use App\Modules\Map\Filament\Resources\PlayerMapResource\Pages;
use App\Modules\Map\PlayerMap;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerMapResource extends Resource
{
    protected static ?string $model = PlayerMap::class;

    protected static ?string $slug = 'player-maps';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Map';

    protected static ?string $pluralLabel = 'Map (beta)';

    //    public static function form(Form $form): Form
    //    {
    //        return $form
    //            ->schema([
    //                TextInput::make('coordinate_position')
    //                    ->required()
    //                    ->integer(),
    //
    //                Select::make('player_id')
    //                    ->required()
    //                    ->relationship('player', 'nickname'),
    //            ]);
    //    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('player.full_nickname')
                    ->label(''),
            ])
            ->reorderable('coordinate_position')
            ->defaultSort('coordinate_position')
            ->selectable(false)
            ->paginated(false)
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                //                BulkActionGroup::make([
                //                    DeleteBulkAction::make(),
                //                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerMaps::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}

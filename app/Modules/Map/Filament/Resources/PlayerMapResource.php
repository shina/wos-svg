<?php

namespace App\Modules\Map\Filament\Resources;

use App\Modules\Map\Filament\Resources\PlayerMapResource\Pages;
use App\Modules\Map\PlayerMap;
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

    protected static ?string $pluralLabel = 'Map';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('coordinate_position')
                    ->label('Position'),
                TextColumn::make('player.full_nickname')
                    ->label('Player'),
            ])
            ->reorderable('coordinate_position')
            ->defaultSort('coordinate_position')
            ->paginated(false)
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerMaps::route('/'),
            'edit' => Pages\EditPlayerMap::route('/{record}/edit'),
            'create' => Pages\CreatePlayerMap::route('/create/{position}'),
            'map' => Pages\ListPlayerMapsOnMap::route('/map'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}

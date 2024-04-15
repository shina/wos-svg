<?php

namespace App\Modules\Players\Filament\Resources;

use App\Modules\Players\Filament\Resources\PlayerResource\Pages;
use App\Modules\Players\Player;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $slug = 'players';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?Player $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?Player $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('nickname')
                    ->required(),

                TextInput::make('rating')
                    ->required()
                    ->integer()
                    ->minValue(0)
                    ->maxValue(10),

                TextInput::make('in_game_id')
                    ->required()
                    ->prefix('#'),

                TextInput::make('rank')
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(5)
                    ->prefix('R'),

                RichEditor::make('background')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchable()
            ->columns([
                TextColumn::make('in_game_id')->prefix('#'),

                TextColumn::make('nickname'),

                TextColumn::make('rank')
                    ->sortable()
                    ->prefix('R'),

                TextColumn::make('rating')
                    ->sortable()
                    ->formatStateUsing(function (int $state) {
                        $filledStars = collect($state === 0 ? [] : range(1, $state))->map(fn () => '★');
                        $emptyStars = collect($state === 10 ? [] : range($state, 9))->map(fn () => '☆');

                        return $filledStars->merge($emptyStars)->join('');
                    }),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}

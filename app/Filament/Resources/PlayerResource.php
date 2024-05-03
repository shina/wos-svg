<?php

namespace App\Filament\Resources;

use App\Enums\Language;
use App\Libraries\Integrations\Deepl\Deepl;
use App\Libraries\Integrations\Deepl\Requests\TranslateText\Request\TranslateTextData;
use App\Models\Player;
use App\Modules\Players\Filament\Resources\PlayerResource\RelationManagers\CommentsRelationManager;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction;
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
use Illuminate\Support\Collection;

class PlayerResource extends Resource
{
    protected static ?string $model = \App\Models\Player::class;

    protected static ?string $slug = 'players';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('in_game_id')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->prefix('#'),

                TextInput::make('nickname')
                    ->required(),

                Toggle::make('has_translation')
                    ->formatStateUsing(fn (Get $get) => $get('translated_nickname') !== null)
                    ->afterStateUpdated(function (Get $get, Set $set, Deepl $deepl) {
                        if ($get('has_translation') === true && $get('nickname') !== null) {
                            $response = $deepl->translate(TranslateTextData::from(
                                $get('nickname'),
                                null,
                                Language::en
                            ));

                            $set('translated_nickname', $response->translations[0]->text ?? '???');
                        }
                    })
                    ->columnSpan(fn (bool $state) => $state === true ? 1 : 2)
                    ->live(),

                TextInput::make('translated_nickname')
                    ->required()
                    ->hidden(fn (Get $get) => $get('has_translation') === false),

                TextInput::make('rating')
                    ->required()
                    ->integer()
                    ->default(10)
                    ->minValue(0)
                    ->maxValue(10),

                TextInput::make('rank')
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(5)
                    ->prefix('R'),

                Section::make('Background')
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        RichEditor::make('background')
                            ->label(''),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('in_game_id')
                    ->label('')
                    ->prefix('#')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->width(1)
                    ->searchable(),

                TextColumn::make('nickname')
                    ->searchable()
                    ->label(''),

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
            ->defaultSort('rating')
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
                BulkAction::make('change-rank')
                    ->icon('heroicon-s-pencil-square')
                    ->form(function (Form $form) {
                        return $form
                            ->schema([
                                TextInput::make('rank')
                                    ->required(),
                            ]);
                    })
                    ->action(function (Collection $records, array $data) {
                        Player::query()
                            ->whereIn('id', $records->pluck('id'))
                            ->update(['rank' => $data['rank']]);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PlayerResource\Pages\ListPlayers::route('/'),
            'create' => \App\Filament\Resources\PlayerResource\Pages\CreatePlayer::route('/create'),
            'edit' => \App\Filament\Resources\PlayerResource\Pages\EditPlayer::route('/{record}/edit'),
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

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }
}

<?php

namespace App\Modules\Participation\Filament\Resources;

use App\Modules\Participation\Event;
use App\Modules\Participation\EventCategory;
use App\Modules\Participation\Filament\Resources\EventCategoryResource\Pages\ListEventCategories;
use App\Modules\Participation\Filament\Resources\EventResource\Pages;
use App\Modules\Participation\Filament\Resources\EventResource\RelationManagers\AttendeesRelationManager;
use App\Modules\Participation\Filament\Resources\PlayerParticipationResource\Pages\ListPlayerParticipations;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $slug = 'events';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Event Participation';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->required(),

                DatePicker::make('date')
                    ->required(),

                TagsInput::make('categories')
                    ->placeholder('Add Category')
                    ->formatStateUsing(function (Event $record) {
                        return $record
                            ->categories()
                            ->pluck('category');
                    })
                    ->saveRelationshipsUsing(function (Collection $state, Event $record) {
                        $categoryIds = $state
                            ->map(fn (string $item) => EventCategory::createOrFirst(['category' => $item]))
                            ->pluck('id');

                        $record->categories()->sync($categoryIds);
                    })
                    ->suggestions(fn () => EventCategory::pluck('category')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->date(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                SelectFilter::make('categories')
                    ->multiple()
                    ->relationship('categories', 'category')
                    ->preload(),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'players' => ListPlayerParticipations::route('/players'),
            'categories' => ListEventCategories::route('/event-categories'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getRelations(): array
    {
        return [
            AttendeesRelationManager::class,
        ];
    }
}

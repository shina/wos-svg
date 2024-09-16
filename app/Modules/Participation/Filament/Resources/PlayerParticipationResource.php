<?php

namespace App\Modules\Participation\Filament\Resources;

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\EventCategory;
use App\Modules\Participation\Filament\Resources\PlayerParticipationResource\Pages\ListPlayerParticipations;
use App\Modules\Participation\PlayerParticipation;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PlayerParticipationResource extends Resource
{
    protected static ?string $model = PlayerParticipation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Event Participation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('player.in_game_id')
                    ->label('')
                    ->prefix('#')
                    ->size(TextColumnSize::ExtraSmall)
                    ->width(1)
                    ->searchable(),
                TextColumn::make('player.full_nickname')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query
                            ->whereExists(fn (\Illuminate\Database\Query\Builder $query) => $query
                                ->from('players')
                                ->where('player_participations.player_id', DB::raw('"players"."id"'))
                                ->where('players.nickname', 'like', "%{$search}%"))
                            ->orWhereExists(fn (\Illuminate\Database\Query\Builder $query) => $query
                                ->from('players')
                                ->where('player_participations.player_id', DB::raw('"players"."id"'))
                                ->where('players.translated_nickname', 'like', "%{$search}%"));
                    })
                    ->label(''),
                ColumnGroup::make('Participation rate')
                    ->columns([
                        TextColumn::make('last_3_events')
                            ->formatStateUsing(fn (string $state) => $state === '-' ? $state : "$state%")
                            ->default('-')
                            ->sortable(),
                        TextColumn::make('one_month')
                            ->formatStateUsing(fn (string $state) => $state === '-' ? $state : "$state%")
                            ->default('-')
                            ->sortable(),
                        TextColumn::make('all_time')
                            ->formatStateUsing(fn (string $state) => $state === '-' ? $state : "$state%")
                            ->default('-')
                            ->sortable(),
                    ]),
                //                    ->formatStateUsing(fn (Player $record) => $record->full_nickname),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->multiple()
                    ->options(fn () => EventCategory::pluck('category', 'id'))
                    ->modifyQueryUsing(function (Builder $query, array $state) {
                        if (blank($state['values'])) {
                            return $query->whereNull('combined_categories');
                        }

                        $categoryIds = collect($state['values'])->sort()->toArray();

                        //                        $categoryIds = EventCategory::query()
                        //                            ->whereIn('id', $state['values'])
                        //                            ->orderBy('category')
                        //                            ->pluck('id')
                        //                            ->toArray();

                        return $query->where('combined_categories', implode('-', $categoryIds));
                    }),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\Action::make('See events')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->infolist([
                        RepeatableEntry::make('events')
                            ->getStateUsing(function (PlayerParticipation $record) {
                                $query = Attendee::query()
                                    ->where('player_id', $record->player_id)
                                    ->whereHas('event')
                                    ->with('event')
                                    ->join('events', 'events.id', '=', 'attendees.event_id')
                                    ->where('events.date', '<', now()->toISOString())
                                    ->orderBy('events.date', 'desc');

                                if ($record->combined_categories !== null) {
                                    $query->whereInAllCategories(
                                        explode('-', $record->combined_categories)
                                    );
                                }

                                return $query->get();
                            })
                            ->hiddenLabel()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('event.name')
                                    ->getStateUsing(fn ($record) => $record->event->name)
                                    ->label('Name'),
                                TextEntry::make('event.date')
                                    ->getStateUsing(fn ($record) => $record->event->date)
                                    ->label('Date')
                                    ->date(),
                                TextEntry::make('is_commitment_fulfilled')
                                    ->label('Attended')
                                    ->getStateUsing(fn (Attendee $record) => $record->is_commitment_fulfilled === true ? '✅' : '❌'),
                            ]),
                    ]),
            ])
            ->bulkActions([
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make(),
                //                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlayerParticipations::route('/'),
            //            'create' => CreatePlayerParticipation::route('/create'),
            //            'edit' => EditPlayerParticipation::route('/{record}/edit'),
        ];
    }
}

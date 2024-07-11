<?php

namespace App\Modules\Participation\Filament\Resources;

use App\Models\Player;
use App\Modules\Participation\Attendee;
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
                //
            ])
            ->actions([
                Tables\Actions\Action::make('See events')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->infolist([
                        RepeatableEntry::make('player.attendees')
                            ->hiddenLabel()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('event.name')
                                    ->label('Name'),
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

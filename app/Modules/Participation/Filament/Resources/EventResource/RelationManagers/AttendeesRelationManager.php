<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\RelationManagers;

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

class AttendeesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendees';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Select::make('player_id')
                                ->required()
                                ->relationship('player', 'nickname')
                                ->unique(
                                    ignoreRecord: true,
                                    modifyRuleUsing: fn (Unique $rule) => $rule->where('event_id', $this->ownerRecord->id)
                                )
                                ->searchable(['nickname', 'in_game_id', 'translated_nickname']),

                            Forms\Components\Toggle::make('is_commitment_fulfilled'),
                        ]),
                    Forms\Components\Section::make('Nicknames reference')
                        ->grow(false)
                        ->schema([
                            Forms\Components\ViewField::make('nickname reference')
                                ->view('participation::filament.event.attendee-nickname-reference')
                                ->viewData([
                                    'nicknames' => Player::query()
                                        ->whereNotNull('translated_nickname')
                                        ->get()
                                        ->map(fn (Player $player) => $player->full_nickname),
                                ]),
                        ]),
                ])->from('sm'),

                Forms\Components\Hidden::make('event_id')
                    ->formatStateUsing(fn () => $this->ownerRecord->id),
            ]);
    }

    public function table(Table $table): Table
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
                                ->where('attendees.player_id', DB::raw('"players"."id"'))
                                ->where('players.nickname', 'like', "%{$search}%"))
                            ->orWhereExists(fn (\Illuminate\Database\Query\Builder $query) => $query
                                ->from('players')
                                ->where('attendees.player_id', DB::raw('"players"."id"'))
                                ->where('players.translated_nickname', 'like', "%{$search}%"));
                    })
                    ->label(''),
                Tables\Columns\ToggleColumn::make('is_commitment_fulfilled'),
                ColumnGroup::make('Participation rate')
                    ->columns([
                        TextColumn::make('playerParticipation.last_3_events')
                            ->formatStateUsing(fn (string $state) => $state === '-' ? $state : "$state%")
                            ->default('-')
                            ->sortable(),
                        TextColumn::make('playerParticipation.one_month')
                            ->formatStateUsing(fn (string $state) => $state === '-' ? $state : "$state%")
                            ->default('-')
                            ->sortable(),
                        TextColumn::make('playerParticipation.all_time')
                            ->formatStateUsing(fn (string $state) => $state === '-' ? $state : "$state%")
                            ->default('-')
                            ->sortable(),
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Add remaining players')
                        ->requiresConfirmation()
                        ->action(function () {
                            /** @var Event $event */
                            $event = $this->ownerRecord;

                            $existingPlayerIds = $event->attendees->pluck('player_id');

                            Player::query()
                                ->whereNotIn('id', $existingPlayerIds)
                                ->get(['id'])
                                ->pluck('id')
                                ->each(function (int $playerId) use ($event) {
                                    Attendee::create([
                                        'player_id' => $playerId,
                                        'event_id' => $event->id,
                                    ]);
                                });
                        }),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

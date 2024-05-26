<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\RelationManagers;

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Event;
use App\Modules\Participation\Filament\Resources\EventResource\Table\Columns\TrustLevelColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
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
                Tables\Columns\TextColumn::make('player.nickname'),
                Tables\Columns\ToggleColumn::make('is_commitment_fulfilled'),
                TrustLevelColumn::make(fn (Attendee $record) => $record->player_id),
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

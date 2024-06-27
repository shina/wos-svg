<?php

namespace App\Modules\Agreement\Filament\Resources\AgreementResource\RelationManagers;

use App\Filament\Resources\PlayerResource\Table\Columns\InGameIdColumn;
use App\Models\Player;
use App\Modules\Agreement\Agreement;
use App\Modules\Agreement\Respondent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RespondentsRelationManager extends RelationManager
{
    protected static string $relationship = 'respondents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Respondent')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->selectable(false)
            ->searchable()
            ->columns([
                InGameIdColumn::make('player.in_game_id'),
                Tables\Columns\TextColumn::make('player.full_nickname')
                    ->searchable(true, function (Builder $query, string $search) {
                        $query
                            ->whereExists(fn (\Illuminate\Database\Query\Builder $query) => $query
                                ->from('players')
                                ->where('respondents.player_id', DB::raw('"players"."id"'))
                                ->where('players.nickname', 'like', "%{$search}%"))
                            ->orWhereExists(fn (\Illuminate\Database\Query\Builder $query) => $query
                                ->from('players')
                                ->where('respondents.player_id', DB::raw('"players"."id"'))
                                ->where('players.translated_nickname', 'like', "%{$search}%"));
                    }),
                Tables\Columns\SelectColumn::make('value')
                    ->sortable()
                    ->options(fn () => collect($this->ownerRecord->options)->pluck('name')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Add remaining players')
                    ->after(fn () => Notification::make()->title('Players added')->success()->send())
                    ->action(function () {
                        /** @var Agreement $agreement */
                        $agreement = $this->ownerRecord;

                        $existingPlayerIds = $agreement->respondents->pluck('player_id');

                        Player::query()
                            ->whereNotIn('id', $existingPlayerIds)
                            ->get(['id'])
                            ->pluck('id')
                            ->each(function (int $playerId) use ($agreement) {
                                Respondent::create([
                                    'player_id' => $playerId,
                                    'agreement_id' => $agreement->id,
                                ]);
                            });
                    }),
            ])
            ->actions([
                //                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make(),
                //                ]),
            ]);
    }
}

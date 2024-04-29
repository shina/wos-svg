<?php

namespace App\Modules\Participation\Filament\Resources\EventResource\RelationManagers;

use App\Modules\Participation\Enums\CommitmentLevel;
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
            ->schema([
                Forms\Components\Select::make('player_id')
                    ->required()
                    ->relationship('player', 'nickname')
                    ->unique(modifyRuleUsing: fn (Unique $rule) => $rule->where('event_id', $this->ownerRecord->id))
                    ->searchable(),

                Forms\Components\Select::make('commitment_level')
                    ->required()
                    ->default(CommitmentLevel::join)
                    ->options(
                        CommitmentLevel::collect()
                            ->mapWithKeys(fn (CommitmentLevel $commitmentLevel) => [$commitmentLevel->name => $commitmentLevel->value])
                    ),

                Forms\Components\Toggle::make('is_commitment_fulfilled'),

                Forms\Components\Textarea::make('comment'),

                Forms\Components\Hidden::make('event_id')
                    ->formatStateUsing(fn () => $this->ownerRecord->id),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('player.nickname'),
                Tables\Columns\TextColumn::make('commitment_level'),
                Tables\Columns\ToggleColumn::make('is_commitment_fulfilled'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
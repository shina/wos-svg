<?php

namespace App\Modules\Players\Filament\Resources\PlayerResource\RelationManagers;

use App\Modules\Players\Comment;
use App\Modules\Players\Services\RatingCalculator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'Reviews';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('rating')
                    ->label('Rate')
                    ->columnSpan(2)
                    ->inline()
                    ->inlineLabel(false)
                    ->options([-1 => '👎', 1 => '👍']),

                Forms\Components\Textarea::make('content')
                    ->columnSpan(2)
                    ->label('Write something')
                    ->required(),

                Forms\Components\Hidden::make('reviewer_user_id')
                    ->formatStateUsing(fn () => auth()->user()->id),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reviewerUser.name')
                    ->label('')
                    ->description(fn (Comment $record) => $record->created_at->longAbsoluteDiffForHumans()),
                TextColumn::make('rating')
                    ->label('')
                    ->formatStateUsing(function (int $state) {
                        return match ($state) {
                            -1 => '👎',
                            1 => '👍',
                            default => '?'
                        };
                    }),
                TextColumn::make('content')
                    ->label(''),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Write review'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function (RatingCalculator $ratingCalculator, $livewire) {
                    $player = $this->ownerRecord;
                    $player->rating = $ratingCalculator->calculate($player);
                    $player->save();

                    $this->dispatch('refresh');
                }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}

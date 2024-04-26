<?php

namespace App\Modules\Players\Filament\Resources\PlayerResource\RelationManagers;

use App\Modules\Players\Comment;
use App\Modules\Players\Enums\Rate;
use App\Modules\Players\Services\RatingCalculator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
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
                    ->formatStateUsing(fn (int $state) => Rate::fromNumber($state)),
                TextColumn::make('content')
                    ->label(''),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('how-it-works')
                    ->link()
                    ->size(ActionSize::ExtraSmall)
                    ->label('')
                    ->icon('heroicon-c-question-mark-circle')
                    ->infolist([
                        TextEntry::make('title')
                            ->hiddenLabel()
                            ->weight(FontWeight::Bold)
                            ->state('How does it work?'),
                        TextEntry::make('text')
                            ->hiddenLabel()
                            ->state('The review system uses a thumbs up/down rating. Every player starts with '.
                                '10 stars. Each review can increase or decrease the overall rating, but the rating '.
                                'cannot exceed 10 stars or drop below 0 stars.'),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->modalWidth(MaxWidth::Small),

                Tables\Actions\CreateAction::make()
                    ->label('Write review')
                    ->after(function (RatingCalculator $ratingCalculator) {
                        $player = $this->ownerRecord;
                        $player->rating = $ratingCalculator->calculate($player);
                        $player->save();

                        $this->dispatch('refresh');
                    }),
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

<?php

namespace App\Filament\Resources\PlayerResource\Pages;

use App\Filament\Resources\PlayerResource;
use App\Models\Player;
use App\Modules\PlayerReview\Review;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ListRecords;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('last-comments')
                ->label('Lastest comments')
                ->color('gray')
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->infolist(function (Infolist $infolist) {
                    $comments = Review::query()
                        ->limit(25)
                        ->activePlayers()
                        ->with(['player', 'reviewerUser'])
                        ->orderBy('created_at', 'desc')
                        ->get();

                    return $infolist
                        ->state(['comments' => InfolistCommentData::collect($comments)])
                        ->schema([
                            RepeatableEntry::make('comments')
                                ->hiddenLabel()
                                ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                ->schema([
                                    TextEntry::make('player'),
                                    TextEntry::make('rate'),
                                    TextEntry::make('commentBy'),
                                    TextEntry::make('when')
                                        ->since(),
                                    TextEntry::make('comment')
                                        ->columnSpan(['sm' => 2, 'md' => 3, 'lg' => 4]),
                                ]),
                        ]);
                }),
            Action::make('add-player')
                ->label('Add existing player')
                ->form(function (Form $form) {
                    return $form->schema([
                        Select::make('player_id')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return Player::query()
                                    ->onlyAllianceOrphan()
                                    ->onlyTrashed()
                                    ->where('nickname', 'like', "%$search%")
                                    ->orWhere('translated_nickname', 'like', "%$search%")
                                    ->orWhere('in_game_id', '=', "$search")
                                    ->pluck('nickname', 'id');
                            }),
                    ]);
                })
                ->action(function (array $data) {
                    $player = Player::query()
                        ->onlyAllianceOrphan()
                        ->withTrashed()
                        ->find($data['player_id']);
                    $player->alliance_id = allianceId();
                    $player->restore();
                }),
            CreateAction::make(),
        ];
    }
}

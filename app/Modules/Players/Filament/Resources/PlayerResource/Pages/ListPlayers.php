<?php

namespace App\Modules\Players\Filament\Resources\PlayerResource\Pages;

use App\Modules\Players\Comment;
use App\Modules\Players\Filament\Resources\PlayerResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
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
                    $comments = Comment::query()
                        ->limit(25)
                        ->orderBy('created_at', 'desc')
                        ->get();

                    return $infolist
                        ->state(['comments' => InfolistCommentData::collect($comments)])
                        ->schema([
                            RepeatableEntry::make('comments')
                                ->hiddenLabel()
                                ->columns(4)
                                ->schema([
                                    TextEntry::make('player'),
                                    TextEntry::make('rate'),
                                    TextEntry::make('commentBy'),
                                    TextEntry::make('when')
                                        ->since(),
                                    TextEntry::make('comment')
                                        ->columnSpan(4),
                                ]),
                        ]);
                }),
            CreateAction::make(),
        ];
    }
}

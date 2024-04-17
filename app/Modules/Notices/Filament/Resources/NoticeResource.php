<?php

namespace App\Modules\Notices\Filament\Resources;

use App\Modules\Notices\Filament\Resources\NoticeResource\RelationManagers\TranslatedNoticesRelationManager;
use App\Modules\Notices\Notice;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NoticeResource extends Resource
{
    protected static ?string $model = Notice::class;

    protected static ?string $slug = 'notices';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $contentMaxLength = 300;

        return $form
            ->columns(1)
            ->schema([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn (?Notice $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn (?Notice $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ]),

                TextInput::make('title')
                    ->unique(ignoreRecord: true)
                    ->required(),

                Textarea::make('content')
                    ->maxLength($contentMaxLength)
                    ->rows(10)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('priority')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('copy-clipboard')
                    ->label('')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->state('copy')
                    ->copyable()
                    ->copyableState(function (Notice $record) {
                        return "$record->title\n$record->content";
                    }),
            ])
            ->defaultSort('priority')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Modules\Notices\Filament\Resources\NoticeResource\Pages\ListNotices::route('/'),
            'create' => \App\Modules\Notices\Filament\Resources\NoticeResource\Pages\CreateNotice::route('/create'),
            'edit' => \App\Modules\Notices\Filament\Resources\NoticeResource\Pages\EditNotice::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    public static function getRelations(): array
    {
        return [
            TranslatedNoticesRelationManager::class,
        ];
    }
}

<?php

namespace App\Modules\Notices\Filament\Resources;

use App\Filament\Resources\NoticeResource\Pages;
use App\Modules\Notices\Models\Notice;
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
        return $form
            ->columns(1)
            ->schema([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?Notice $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?Notice $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ]),

                TextInput::make('title')
                    ->unique(ignoreRecord: true)
                    ->required(),

                Textarea::make('content')
                    ->maxLength(300)
                    ->rows(10)
                    ->required(),

                Grid::make()
                    ->columns(4)
                    ->schema([
                        TextInput::make('priority')
                            ->numeric()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('priority')
                    ->sortable()
            ])
            ->defaultSort('priority', 'desc')
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
}

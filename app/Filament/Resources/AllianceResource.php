<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllianceResource\Pages;
use App\Models\Alliance;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AllianceResource extends Resource
{
    protected static ?string $model = Alliance::class;

    protected static ?string $slug = 'alliances';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?Alliance $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?Alliance $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('acronym')
                    ->maxLength(3)
                    ->required(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('state')
                    ->numeric()
                    ->required(),

                TextInput::make('domain')
                    ->prefix('https://')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->formatStateUsing(fn (Alliance $record) => $record->full_name)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('state'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Action::make('switch-alliance')
                    ->label('Switch')
                    ->action(function (Alliance $record) {
                        session()->put('selected_alliance_id', $record->id);
                        redirect(Pages\ListAlliances::getUrl());
                    }),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlliances::route('/'),
            'create' => Pages\CreateAlliance::route('/create'),
            'edit' => Pages\EditAlliance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}

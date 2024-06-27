<?php

namespace App\Modules\Agreement\Filament\Resources;

use App\Modules\Agreement\Agreement;
use App\Modules\Agreement\Filament\Resources\AgreementResource\Pages;
use App\Modules\Agreement\Filament\Resources\AgreementResource\RelationManagers\RespondentsRelationManager;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgreementResource extends Resource
{
    protected static ?string $model = Agreement::class;

    protected static ?string $slug = 'agreements';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpan(2)
                    ->required(),

                Section::make('Options')
                    ->collapsible()
                    ->collapsed(fn ($record) => $record !== null)
                    ->schema([
                        Repeater::make('options')
                            ->reorderable(fn ($record) => ($record?->respondents()->count() ?? 0) === 0)
                            ->deletable(fn ($record) => ($record?->respondents()->count() ?? 0) === 0)
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('name'),
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('report')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->infolist([
                        KeyValueEntry::make('result')
                            ->label('')
                            ->keyLabel('Option')
                            ->valueLabel('Total count')
                            ->getStateUsing(function (Agreement $record) {
                                return collect($record->options)
                                    ->mapWithKeys(function ($value, $key) use ($record) {
                                        $count = $record->respondents()
                                            ->where('value', $key)
                                            ->count();

                                        return [$value['name'] => $count];
                                    });
                            }),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
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
            'index' => Pages\ListAgreements::route('/'),
            'create' => Pages\CreateAgreement::route('/create'),
            'edit' => Pages\EditAgreement::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    public static function getRelations(): array
    {
        return [
            RespondentsRelationManager::class,
        ];
    }
}

<?php

namespace App\Modules\Framework\IssueTracker\Filament\Resources;

use App\Enums\Role;
use App\Modules\Framework\IssueTracker\Issue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static ?string $slug = 'issue-tracker/issues';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'More';

    protected static ?string $navigationLabel = 'Report bug or Suggest feature';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('title')
                    ->required(),

                RichEditor::make('description')
                    ->required(),

                FileUpload::make('attachments')
                    ->image()
                    ->imageEditor()
                    ->multiple(),

                Hidden::make('user_id')
                    ->formatStateUsing(fn () => auth()->user()->id)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if (! $user->hasRole(Role::ADMIN)) {
                    $query->where('user_id', $user->id);
                }
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Reported by')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_solved')
                    ->hidden(fn () => ! auth()->user()->hasRole(Role::ADMIN)),

                TextColumn::make('created_at')
                    ->date(),
            ])
            ->filters([
                TernaryFilter::make('is_solved')
                    ->default(false)
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('solved_at'),
                        false: fn (Builder $query) => $query->whereNull('solved_at')
                    ),
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
            'index' => \App\Modules\Framework\IssueTracker\Filament\Resources\Pages\ListIssues::route('/'),
            'create' => \App\Modules\Framework\IssueTracker\Filament\Resources\Pages\CreateIssue::route('/create'),
            'edit' => \App\Modules\Framework\IssueTracker\Filament\Resources\Pages\EditIssue::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }
}

<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\UserResource\Pages;
use App\Models\Alliance;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->required(),

                DatePicker::make('email_verified_at')
                    ->label('Email Verified Date'),

                TextInput::make('password')
                    ->required(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?User $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->hasRole(Role::DEV)) {
                    return $query;
                }

                $permissions = $user->permissions;
                if ($permissions->count() === 0) {
                    return $query->whereRaw('0 = 1'); // force result be empty
                }

                return $permissions
                    ->reduce(
                        fn (Builder $query, Permission $permission) => $query->permission($permission->name),
                        $query
                    );
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles')
                    ->badge()
                    ->label('Roles')
                    ->getStateUsing(function (User $user) {
                        return $user->getRoleNames();
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('roles')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                CheckboxList::make('roles')
                                    ->label('')
                                    ->options(
                                        Role::collect()->mapWithKeys(fn (Role $role) => [$role->value => $role->value])
                                    )
                                    ->default(fn (User $user) => $user->getRoleNames()->toArray()),
                                CheckboxList::make('alliances')
                                    ->label('Alliances')
                                    ->options(function () {
                                        $user = auth()->user();

                                        if ($user->hasRole(Role::DEV)) {
                                            return Alliance::all()->pluck('full_name', 'id');
                                        } else {
                                            return Alliance::query()
                                                ->whereIn('id', $user->alliance_permissions)
                                                ->get()
                                                ->pluck('full_name', 'id');
                                        }
                                    })
                                    ->default(function (User $user) {
                                        return $user->alliance_permissions;
                                    })
                                    ->visible(fn () => auth()->user()->hasAnyRole([Role::DEV, Role::ADMIN])),
                            ]),
                    ])
                    ->action(function (array $data, User $user) {
                        $user->syncRoles($data['roles']);
                        $user->syncPermissions(
                            collect($data['alliances'])->map(fn (int $allianceId) => "access alliance-id $allianceId")
                        );
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}

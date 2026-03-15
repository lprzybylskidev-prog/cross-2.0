<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends AdminResource
{
    protected static ?string $model = User::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Users & Teams';

    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Account')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->label('Email address')->email()->required(),
                    DateTimePicker::make('email_verified_at')->label('Email verified at'),
                    Select::make('current_team_id')
                        ->relationship('currentTeam', 'name')
                        ->label('Current team')
                        ->searchable()
                        ->preload(),
                    TextInput::make('password')
                        ->password()
                        ->required(fn(string $operation): bool => $operation === 'create')
                        ->dehydrated(fn(?string $state): bool => filled($state)),
                ]),
            Section::make('Preferences')
                ->columns(2)
                ->schema([
                    Select::make('preferred_locale')
                        ->required()
                        ->options([
                            'pl' => 'Polish',
                            'en' => 'English',
                        ])
                        ->default('pl'),
                    Select::make('preferred_theme')
                        ->required()
                        ->options([
                            'dark' => 'Dark',
                            'light' => 'Light',
                            'system' => 'System',
                        ])
                        ->default('dark'),
                ]),
            Section::make('Access control')->schema([
                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->options(Role::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->relationship('roles', 'name'),
                Select::make('permissions')
                    ->label('Direct permissions')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->options(Permission::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->relationship('permissions', 'name'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->label('Email address')->searchable(),
                TextColumn::make('currentTeam.name')->label('Current team')->searchable(),
                TextColumn::make('roles.name')->label('Roles')->badge()->separator(','),
                TextColumn::make('permissions.name')
                    ->label('Direct permissions')
                    ->badge()
                    ->separator(','),
                TextColumn::make('email_verified_at')->dateTime()->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('preferred_locale')->searchable(),
                TextColumn::make('preferred_theme')->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}

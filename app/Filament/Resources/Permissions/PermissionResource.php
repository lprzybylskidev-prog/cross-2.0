<?php

declare(strict_types=1);

namespace App\Filament\Resources\Permissions;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\Permissions\Pages\ManagePermissions;
use App\Models\Permission;
use App\Models\Role;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PermissionResource extends AdminResource
{
    protected static ?string $model = Permission::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?int $navigationSort = 20;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Permission')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('guard_name')->required(),
                ]),
            Section::make('Roles')->schema([
                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->options(Role::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->relationship('roles', 'name'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('guard_name')->searchable(),
                TextColumn::make('roles.name')->label('Roles')->badge()->separator(','),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManagePermissions::route('/'),
        ];
    }
}

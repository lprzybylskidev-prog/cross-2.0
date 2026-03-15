<?php

declare(strict_types=1);

namespace App\Filament\Resources\RoleHasPermissions;

use App\Filament\Resources\ReadOnlyResource;
use App\Filament\Resources\RoleHasPermissions\Pages\ManageRoleHasPermissions;
use App\Models\RoleHasPermission;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoleHasPermissionResource extends ReadOnlyResource
{
    protected static ?string $model = RoleHasPermission::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?int $navigationSort = 50;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'permission_id';

    /**
     * @return array<int, TextInput>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('permission_id')->required()->numeric(),
            TextInput::make('role_id')->required()->numeric(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('permission_id')
            ->columns([
                TextColumn::make('permission.name')->label('Permission')->searchable(),
                TextColumn::make('role.name')->label('Role')->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([ViewAction::make()->schema(static::getViewSchemaComponents())])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRoleHasPermissions::route('/'),
        ];
    }
}

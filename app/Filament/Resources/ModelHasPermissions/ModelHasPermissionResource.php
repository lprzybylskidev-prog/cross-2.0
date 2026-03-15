<?php

declare(strict_types=1);

namespace App\Filament\Resources\ModelHasPermissions;

use App\Filament\Resources\ModelHasPermissions\Pages\ManageModelHasPermissions;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\ModelHasPermission;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ModelHasPermissionResource extends ReadOnlyResource
{
    protected static ?string $model = ModelHasPermission::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?int $navigationSort = 40;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'permission_id';

    /**
     * @return array<int, TextInput>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('permission_id')->required()->numeric(),
            TextInput::make('model_type')->required(),
            TextInput::make('model_id')->required()->numeric(),
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
                TextColumn::make('model_type')->searchable(),
                TextColumn::make('model_id')->numeric()->sortable(),
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
            'index' => ManageModelHasPermissions::route('/'),
        ];
    }
}

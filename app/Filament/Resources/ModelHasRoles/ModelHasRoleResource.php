<?php

declare(strict_types=1);

namespace App\Filament\Resources\ModelHasRoles;

use App\Filament\Resources\ModelHasRoles\Pages\ManageModelHasRoles;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\ModelHasRole;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ModelHasRoleResource extends ReadOnlyResource
{
    protected static ?string $model = ModelHasRole::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?int $navigationSort = 30;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'role_id';

    /**
     * @return array<int, TextInput>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('role_id')->required()->numeric(),
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
            ->recordTitleAttribute('role_id')
            ->columns([
                TextColumn::make('role.name')->label('Role')->searchable(),
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
            'index' => ManageModelHasRoles::route('/'),
        ];
    }
}

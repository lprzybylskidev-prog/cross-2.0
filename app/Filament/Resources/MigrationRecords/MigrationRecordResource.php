<?php

declare(strict_types=1);

namespace App\Filament\Resources\MigrationRecords;

use App\Filament\Resources\MigrationRecords\Pages\ManageMigrationRecords;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\MigrationRecord;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MigrationRecordResource extends ReadOnlyResource
{
    protected static ?string $model = MigrationRecord::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit & Maintenance';

    protected static ?int $navigationSort = 20;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'migration';

    /**
     * @return array<int, TextInput>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('id')->label('ID'),
            TextInput::make('migration')->required()->maxLength(255),
            TextInput::make('batch')->numeric(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('migration')
            ->columns([
                TextColumn::make('migration')->searchable(),
                TextColumn::make('batch')->numeric()->sortable(),
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
            'index' => ManageMigrationRecords::route('/'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\CacheLocks;

use App\Filament\Resources\ReadOnlyResource;
use App\Filament\Resources\CacheLocks\Pages\ManageCacheLocks;
use App\Models\CacheLock;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CacheLockResource extends ReadOnlyResource
{
    protected static ?string $model = CacheLock::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 70;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'key';

    /**
     * @return array<int, TextInput>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('key')->required(),
            TextInput::make('owner')->required(),
            TextInput::make('expiration')->required()->numeric(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                TextColumn::make('key')->searchable(),
                TextColumn::make('owner')->searchable(),
                TextColumn::make('expiration')->numeric()->sortable(),
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
            'index' => ManageCacheLocks::route('/'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\CacheEntries;

use App\Filament\Resources\ReadOnlyResource;
use App\Filament\Resources\CacheEntries\Pages\ManageCacheEntries;
use App\Models\CacheEntry;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CacheEntryResource extends ReadOnlyResource
{
    protected static ?string $model = CacheEntry::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 60;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'key';

    /**
     * @return array<int, TextInput|Textarea>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('key')->required()->maxLength(255),
            TextInput::make('expiration')->numeric(),
            Textarea::make('value')->rows(12)->columnSpanFull(),
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
                TextColumn::make('expiration')->numeric()->sortable(),
                TextColumn::make('value')->limit(80)->wrap(),
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
            'index' => ManageCacheEntries::route('/'),
        ];
    }
}

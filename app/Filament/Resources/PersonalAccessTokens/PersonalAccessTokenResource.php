<?php

declare(strict_types=1);

namespace App\Filament\Resources\PersonalAccessTokens;

use App\Filament\Resources\PersonalAccessTokens\Pages\ManagePersonalAccessTokens;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\PersonalAccessToken;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PersonalAccessTokenResource extends ReadOnlyResource
{
    protected static ?string $model = PersonalAccessToken::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 20;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<int, TextInput|Textarea|DateTimePicker>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('tokenable_type')->required(),
            TextInput::make('tokenable_id')->required()->numeric(),
            Textarea::make('name')->required()->columnSpanFull(),
            TextInput::make('token')->required(),
            Textarea::make('abilities')->rows(8)->columnSpanFull(),
            DateTimePicker::make('last_used_at'),
            DateTimePicker::make('expires_at'),
            DateTimePicker::make('created_at'),
            DateTimePicker::make('updated_at'),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('tokenable_type')->label('Tokenable type')->searchable(),
                TextColumn::make('tokenable_id')->numeric()->sortable(),
                TextColumn::make('name')->limit(30)->searchable(),
                TextColumn::make('token')->searchable(),
                TextColumn::make('last_used_at')->dateTime()->sortable(),
                TextColumn::make('expires_at')->dateTime()->sortable(),
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
            ->recordActions([ViewAction::make()->schema(static::getViewSchemaComponents())])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePersonalAccessTokens::route('/'),
        ];
    }
}

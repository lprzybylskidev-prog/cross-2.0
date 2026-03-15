<?php

declare(strict_types=1);

namespace App\Filament\Resources\PasswordResetTokens;

use App\Filament\Resources\PasswordResetTokens\Pages\ManagePasswordResetTokens;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\PasswordResetToken;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PasswordResetTokenResource extends ReadOnlyResource
{
    protected static ?string $model = PasswordResetToken::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 80;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'email';

    /**
     * @return array<int, TextInput>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('email')->label('Email address')->email()->required(),
            TextInput::make('token')->required(),
            TextInput::make('created_at')->label('Created at'),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                TextColumn::make('email')->label('Email address')->searchable(),
                TextColumn::make('token')->searchable(),
                TextColumn::make('created_at')
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
            'index' => ManagePasswordResetTokens::route('/'),
        ];
    }
}

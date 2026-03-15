<?php

declare(strict_types=1);

namespace App\Filament\Resources\SessionRecords;

use App\Filament\Resources\ReadOnlyResource;
use App\Filament\Resources\SessionRecords\Pages\ManageSessionRecords;
use App\Models\SessionRecord;
use BackedEnum;
use Carbon\CarbonImmutable;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SessionRecordResource extends ReadOnlyResource
{
    protected static ?string $model = SessionRecord::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    /**
     * @return array<int, TextInput|Textarea>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('id')->required()->maxLength(255),
            TextInput::make('user_id')->label('User ID')->numeric(),
            TextInput::make('ip_address')->label('IP address'),
            Textarea::make('user_agent')->rows(5)->columnSpanFull(),
            Textarea::make('payload')->rows(12)->columnSpanFull(),
            TextInput::make('last_activity')->label('Last activity')->numeric(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('user.email')->label('User')->searchable(),
                TextColumn::make('ip_address')->label('IP address')->searchable(),
                TextColumn::make('last_activity')
                    ->label('Last activity')
                    ->state(
                        static fn(
                            SessionRecord $record,
                        ): string => CarbonImmutable::createFromTimestamp(
                            (int) $record->last_activity,
                        )->toDateTimeString(),
                    ),
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
            'index' => ManageSessionRecords::route('/'),
        ];
    }
}

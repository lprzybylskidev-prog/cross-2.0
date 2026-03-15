<?php

declare(strict_types=1);

namespace App\Filament\Resources\AuditEntries;

use App\Filament\Resources\ReadOnlyResource;
use App\Filament\Resources\AuditEntries\Pages\ManageAuditEntries;
use App\Models\AuditEntry;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditEntryResource extends ReadOnlyResource
{
    protected static ?string $model = AuditEntry::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit & Maintenance';

    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'event';

    /**
     * @return array<int, TextInput|Textarea>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('event')->required()->maxLength(255),
            TextInput::make('auditable_type')->label('Auditable type'),
            TextInput::make('auditable_id')->label('Auditable ID'),
            TextInput::make('user_type')->label('Actor type'),
            TextInput::make('user_id')->label('Actor ID'),
            TextInput::make('url')->label('URL'),
            TextInput::make('ip_address')->label('IP address'),
            TextInput::make('user_agent')->label('User agent'),
            TextInput::make('tags')->label('Tags'),
            TextInput::make('created_at')->label('Created at'),
            TextInput::make('updated_at')->label('Updated at'),
            Textarea::make('old_values_json')->label('Old values')->rows(10)->columnSpanFull(),
            Textarea::make('new_values_json')->label('New values')->rows(10)->columnSpanFull(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('event')
            ->columns([
                TextColumn::make('event')->badge()->searchable(),
                TextColumn::make('auditable_type')
                    ->label('Auditable type')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('auditable_id')->label('Auditable ID')->sortable(),
                TextColumn::make('user_type')->label('Actor type')->searchable(),
                TextColumn::make('user_id')->label('Actor ID')->sortable(),
                TextColumn::make('url')->label('URL')->limit(40)->searchable()->toggleable(),
                TextColumn::make('ip_address')->label('IP address')->searchable()->toggleable(),
                TextColumn::make('created_at')->label('Created at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema(static::getViewSchemaComponents())
                    ->mutateRecordDataUsing(static function (array $data): array {
                        $data['old_values_json'] = json_encode(
                            $data['old_values'] ?? [],
                            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
                        );
                        $data['new_values_json'] = json_encode(
                            $data['new_values'] ?? [],
                            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
                        );

                        return $data;
                    }),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAuditEntries::route('/'),
        ];
    }
}

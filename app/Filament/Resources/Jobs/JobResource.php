<?php

declare(strict_types=1);

namespace App\Filament\Resources\Jobs;

use App\Filament\Resources\Jobs\Pages\ManageJobs;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\Job;
use BackedEnum;
use Carbon\CarbonImmutable;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobResource extends ReadOnlyResource
{
    protected static ?string $model = Job::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 30;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    /**
     * @return array<int, TextInput|Textarea>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('id')->label('ID'),
            TextInput::make('queue')->required(),
            Textarea::make('payload')->required()->rows(14)->columnSpanFull(),
            TextInput::make('attempts')->required()->numeric(),
            TextInput::make('reserved_at')->numeric(),
            TextInput::make('available_at')->required()->numeric(),
            TextInput::make('created_at')->numeric(),
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
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('queue')->searchable(),
                TextColumn::make('attempts')->numeric()->sortable(),
                TextColumn::make('reserved_at')
                    ->label('Reserved at')
                    ->state(
                        static fn(Job $record): ?string => $record->reserved_at === null
                            ? null
                            : CarbonImmutable::createFromTimestamp(
                                (int) $record->reserved_at,
                            )->toDateTimeString(),
                    ),
                TextColumn::make('available_at')
                    ->label('Available at')
                    ->state(
                        static fn(Job $record): string => CarbonImmutable::createFromTimestamp(
                            (int) $record->available_at,
                        )->toDateTimeString(),
                    ),
                TextColumn::make('created_at')
                    ->label('Created at')
                    ->state(
                        static fn(Job $record): string => CarbonImmutable::createFromTimestamp(
                            (int) $record->created_at,
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
            'index' => ManageJobs::route('/'),
        ];
    }
}

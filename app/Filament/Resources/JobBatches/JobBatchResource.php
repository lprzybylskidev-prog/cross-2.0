<?php

declare(strict_types=1);

namespace App\Filament\Resources\JobBatches;

use App\Filament\Resources\JobBatches\Pages\ManageJobBatches;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\JobBatch;
use BackedEnum;
use Carbon\CarbonImmutable;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobBatchResource extends ReadOnlyResource
{
    protected static ?string $model = JobBatch::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 40;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<int, TextInput|Textarea>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('id')->label('ID'),
            TextInput::make('name')->required(),
            TextInput::make('total_jobs')->required()->numeric(),
            TextInput::make('pending_jobs')->required()->numeric(),
            TextInput::make('failed_jobs')->required()->numeric(),
            Textarea::make('failed_job_ids')->required()->rows(6)->columnSpanFull(),
            Textarea::make('options')->rows(6)->columnSpanFull(),
            TextInput::make('cancelled_at')->numeric(),
            TextInput::make('created_at')->numeric(),
            TextInput::make('finished_at')->numeric(),
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
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('total_jobs')->numeric()->sortable(),
                TextColumn::make('pending_jobs')->numeric()->sortable(),
                TextColumn::make('failed_jobs')->numeric()->sortable(),
                TextColumn::make('cancelled_at')
                    ->label('Cancelled at')
                    ->state(
                        static fn(JobBatch $record): ?string => $record->cancelled_at === null
                            ? null
                            : CarbonImmutable::createFromTimestamp(
                                (int) $record->cancelled_at,
                            )->toDateTimeString(),
                    ),
                TextColumn::make('created_at')
                    ->label('Created at')
                    ->state(
                        static fn(JobBatch $record): string => CarbonImmutable::createFromTimestamp(
                            (int) $record->created_at,
                        )->toDateTimeString(),
                    ),
                TextColumn::make('finished_at')
                    ->label('Finished at')
                    ->state(
                        static fn(JobBatch $record): ?string => $record->finished_at === null
                            ? null
                            : CarbonImmutable::createFromTimestamp(
                                (int) $record->finished_at,
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
            'index' => ManageJobBatches::route('/'),
        ];
    }
}

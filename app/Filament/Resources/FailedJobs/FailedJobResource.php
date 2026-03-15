<?php

declare(strict_types=1);

namespace App\Filament\Resources\FailedJobs;

use App\Filament\Resources\FailedJobs\Pages\ManageFailedJobs;
use App\Filament\Resources\ReadOnlyResource;
use App\Models\FailedJob;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FailedJobResource extends ReadOnlyResource
{
    protected static ?string $model = FailedJob::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 50;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'uuid';

    /**
     * @return array<int, TextInput|Textarea|DateTimePicker>
     */
    protected static function getViewSchemaComponents(): array
    {
        return [
            TextInput::make('uuid')->label('UUID')->required(),
            Textarea::make('connection')->required()->columnSpanFull(),
            Textarea::make('queue')->required()->columnSpanFull(),
            Textarea::make('payload')->required()->rows(12)->columnSpanFull(),
            Textarea::make('exception')->required()->rows(16)->columnSpanFull(),
            DateTimePicker::make('failed_at')->required(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getViewSchemaComponents());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('uuid')
            ->columns([
                TextColumn::make('uuid')->label('UUID')->searchable(),
                TextColumn::make('queue')->limit(40)->searchable(),
                TextColumn::make('connection')->limit(30)->toggleable(),
                TextColumn::make('failed_at')->dateTime()->sortable(),
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
            'index' => ManageFailedJobs::route('/'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\Teams;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\Teams\Pages\ManageTeams;
use App\Models\Team;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamResource extends AdminResource
{
    protected static ?string $model = Team::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Users & Teams';

    protected static ?int $navigationSort = 20;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->relationship('owner', 'name')
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('name')->required(),
            Toggle::make('personal_team')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('owner.name')->label('Owner')->searchable(),
                TextColumn::make('owner.email')->label('Owner email')->searchable(),
                TextColumn::make('name')->searchable(),
                IconColumn::make('personal_team')->boolean(),
                TextColumn::make('users_count')->label('Members')->counts('users')->sortable(),
                TextColumn::make('team_invitations_count')
                    ->label('Invitations')
                    ->counts('teamInvitations')
                    ->sortable(),
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
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTeams::route('/'),
        ];
    }
}

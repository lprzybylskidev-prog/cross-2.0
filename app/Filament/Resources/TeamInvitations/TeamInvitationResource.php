<?php

declare(strict_types=1);

namespace App\Filament\Resources\TeamInvitations;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\TeamInvitations\Pages\ManageTeamInvitations;
use App\Models\TeamInvitation;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamInvitationResource extends AdminResource
{
    protected static ?string $model = TeamInvitation::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Users & Teams';

    protected static ?int $navigationSort = 40;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('team_id')
                ->relationship('team', 'name')
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('email')->label('Email address')->email()->required(),
            TextInput::make('role'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                TextColumn::make('team.name')->label('Team')->searchable(),
                TextColumn::make('team.owner.email')->label('Team owner')->searchable(),
                TextColumn::make('email')->label('Email address')->searchable(),
                TextColumn::make('role')->searchable(),
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
            'index' => ManageTeamInvitations::route('/'),
        ];
    }
}

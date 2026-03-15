<?php

declare(strict_types=1);

namespace App\Filament\Resources\Memberships;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\Memberships\Pages\ManageMemberships;
use App\Models\Membership;
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

class MembershipResource extends AdminResource
{
    protected static ?string $model = Membership::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Users & Teams';

    protected static ?int $navigationSort = 30;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('team_id')
                ->relationship('team', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Select::make('user_id')
                ->relationship('user', 'email')
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('role'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('team.name')->label('Team')->searchable(),
                TextColumn::make('user.name')->label('User name')->searchable(),
                TextColumn::make('user.email')->label('User')->searchable(),
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
            'index' => ManageMemberships::route('/'),
        ];
    }
}

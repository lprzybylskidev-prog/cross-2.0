<?php

declare(strict_types=1);

namespace App\Filament\Resources\TeamInvitations\Pages;

use App\Filament\Resources\TeamInvitations\TeamInvitationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTeamInvitations extends ManageRecords
{
    protected static string $resource = TeamInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

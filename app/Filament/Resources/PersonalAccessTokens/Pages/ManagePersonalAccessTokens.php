<?php

declare(strict_types=1);

namespace App\Filament\Resources\PersonalAccessTokens\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\PersonalAccessTokens\PersonalAccessTokenResource;

class ManagePersonalAccessTokens extends ReadOnlyManageRecords
{
    protected static string $resource = PersonalAccessTokenResource::class;
}

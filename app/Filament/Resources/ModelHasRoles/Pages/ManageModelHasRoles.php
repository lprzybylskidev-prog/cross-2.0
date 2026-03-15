<?php

declare(strict_types=1);

namespace App\Filament\Resources\ModelHasRoles\Pages;

use App\Filament\Resources\ModelHasRoles\ModelHasRoleResource;
use App\Filament\Resources\Pages\ReadOnlyManageRecords;

class ManageModelHasRoles extends ReadOnlyManageRecords
{
    protected static string $resource = ModelHasRoleResource::class;
}

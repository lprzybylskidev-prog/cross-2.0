<?php

declare(strict_types=1);

namespace App\Filament\Resources\ModelHasPermissions\Pages;

use App\Filament\Resources\ModelHasPermissions\ModelHasPermissionResource;
use App\Filament\Resources\Pages\ReadOnlyManageRecords;

class ManageModelHasPermissions extends ReadOnlyManageRecords
{
    protected static string $resource = ModelHasPermissionResource::class;
}

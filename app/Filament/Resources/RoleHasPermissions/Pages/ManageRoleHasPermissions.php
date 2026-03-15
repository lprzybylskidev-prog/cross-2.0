<?php

declare(strict_types=1);

namespace App\Filament\Resources\RoleHasPermissions\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\RoleHasPermissions\RoleHasPermissionResource;

class ManageRoleHasPermissions extends ReadOnlyManageRecords
{
    protected static string $resource = RoleHasPermissionResource::class;
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use Cross\Domain\Security\Permissions\SystemPermission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

final class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::findOrCreate(SystemPermission::Admin->value);
        Permission::findOrCreate(SystemPermission::DebtorsView->value);
        Permission::findOrCreate(SystemPermission::PreferencesUpdate->value);
    }
}

<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Database\Seeders\AdminUserSeeder;

it('creates admin user with admin permission', function (): void {
    $this->seed(AdminUserSeeder::class);

    /** @var User $admin */
    $admin = User::query()->where('email', 'admin@cross.com')->firstOrFail();

    expect($admin->name)->toBe('Cross Admin');
    expect($admin->can(SystemPermission::Admin->value))->toBeTrue();
    expect($admin->can(SystemPermission::DebtorsView->value))->toBeTrue();
});

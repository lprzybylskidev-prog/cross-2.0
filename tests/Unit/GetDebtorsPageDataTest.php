<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Application\Debtors\GetDebtorsPageData;
use Cross\Domain\Security\Permissions\SystemPermission;
use Spatie\Permission\Models\Permission;

it('returns expected payload for debtors permission', function (): void {
    $service = new GetDebtorsPageData();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Permission::findOrCreate(SystemPermission::DebtorsView->value, 'web');
    $user->givePermissionTo(SystemPermission::DebtorsView->value);

    $payload = $service->handle($user);

    expect($payload)->toBe(['canViewDebtors' => true]);
});

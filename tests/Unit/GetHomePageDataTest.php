<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Application\Home\GetHomePageData;
use Cross\Domain\Security\Permissions\SystemPermission;
use Spatie\Permission\Models\Permission;

it('returns expected payload for user permission', function (): void {
    $service = new GetHomePageData();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Permission::findOrCreate(SystemPermission::HomeView->value, 'web');
    $user->givePermissionTo(SystemPermission::HomeView->value);

    $payload = $service->handle($user);

    expect($payload)->toBe(['canViewHome' => true]);
});

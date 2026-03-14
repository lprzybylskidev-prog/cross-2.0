<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Security\Permissions\SystemPermission;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;

it('shares localized breadcrumbs for debtors route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'preferred_locale' => SystemLocale::English->value,
    ]);

    Permission::findOrCreate(SystemPermission::DebtorsView->value, 'web');
    $user->givePermissionTo(SystemPermission::DebtorsView->value);

    $response = $this->actingAs($user)->get('/debtors');

    $response->assertInertia(
        fn(AssertableInertia $page): AssertableInertia => $page
            ->where('breadcrumbs.0.title', 'Debtors')
            ->where('breadcrumbs.0.url', route('debtors.view')),
    );
});

it('shares localized breadcrumbs for profile route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'preferred_locale' => SystemLocale::English->value,
    ]);

    $response = $this->actingAs($user)->get('/user/profile');

    $response->assertInertia(
        fn(AssertableInertia $page): AssertableInertia => $page
            ->where('breadcrumbs.0.title', 'Profile')
            ->where('breadcrumbs.0.url', route('profile.show')),
    );
});

<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Spatie\Permission\Models\Permission;

it('redirects guests from root route to login', function (): void {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

it('redirects guests from debtors route to login', function (): void {
    $response = $this->get('/debtors');

    $response->assertRedirect('/login');
});

it('forbids authenticated users without debtors permissions on root route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertForbidden();
});

it('forbids authenticated users without debtors permissions on debtors route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get('/debtors');

    $response->assertForbidden();
});

it('allows admin user to open debtors route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Permission::findOrCreate(SystemPermission::Admin->value, 'web');
    $user->givePermissionTo(SystemPermission::Admin->value);

    $response = $this->actingAs($user)->get('/debtors');

    $response->assertOk();
});

it('redirects authorized users from root route to debtors route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Permission::findOrCreate(SystemPermission::DebtorsView->value, 'web');
    $user->givePermissionTo(SystemPermission::DebtorsView->value);

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect('/debtors');
});

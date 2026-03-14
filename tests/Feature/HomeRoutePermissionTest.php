<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Spatie\Permission\Models\Permission;

it('redirects guests from home route to login', function (): void {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

it('forbids authenticated users without permissions', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertForbidden();
});

it('allows admin user to open home route', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Permission::findOrCreate(SystemPermission::Admin->value, 'web');
    $user->givePermissionTo(SystemPermission::Admin->value);

    $response = $this->actingAs($user)->get('/');

    $response->assertOk();
});

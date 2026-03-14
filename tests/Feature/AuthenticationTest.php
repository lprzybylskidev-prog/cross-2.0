<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Spatie\Permission\Models\Permission;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();
    Permission::findOrCreate(SystemPermission::DebtorsView->value, 'web');
    $user->givePermissionTo(SystemPermission::DebtorsView->value);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('debtors.view', absolute: false));
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

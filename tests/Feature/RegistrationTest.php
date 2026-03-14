<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip(function () {
    return !Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('registration screen cannot be rendered if support is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
})->skip(function () {
    return Features::enabled(Features::registration());
}, 'Registration support is enabled.');

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('debtors.view', absolute: false));

    /** @var User $user */
    $user = User::query()->where('email', 'test@example.com')->firstOrFail();

    expect($user->can(SystemPermission::DebtorsView->value))
        ->toBeTrue()
        ->and($user->can(SystemPermission::PreferencesUpdate->value))
        ->toBeTrue();
})->skip(function () {
    return !Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

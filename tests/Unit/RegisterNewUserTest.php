<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Application\Auth\Data\NewUserData;
use Cross\Application\Auth\RegisterNewUser;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Domain\Users\ValueObjects\UserEmail;

it('registers a user through the application layer and creates a personal team', function (): void {
    $useCase = app(RegisterNewUser::class);

    $userId = $useCase->handle(
        new NewUserData(
            name: 'Jane Doe',
            email: new UserEmail('jane@example.com'),
            password: 'secret-password',
        ),
    );

    /** @var User $user */
    $user = User::query()->with('ownedTeams')->findOrFail($userId);

    expect($user->email)
        ->toBe('jane@example.com')
        ->and($user->preferred_locale)
        ->toBe('pl')
        ->and($user->preferred_theme)
        ->toBe('dark')
        ->and($user->can(SystemPermission::DebtorsView->value))
        ->toBeTrue()
        ->and($user->can(SystemPermission::PreferencesUpdate->value))
        ->toBeTrue()
        ->and($user->ownedTeams)
        ->toHaveCount(1)
        ->and($user->ownedTeams->first()?->name)
        ->toBe("Jane's Team");
});

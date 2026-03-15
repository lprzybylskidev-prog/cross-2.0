<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Application\Admin\Data\AdminUserData;
use Cross\Application\Admin\EnsureAdminUser;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Domain\Users\ValueObjects\UserEmail;

it('ensures the admin user through the application layer', function (): void {
    $useCase = app(EnsureAdminUser::class);

    $useCase->handle(
        new AdminUserData(
            name: 'Cross Admin',
            email: new UserEmail('admin@cross.com'),
            password: 'cross',
        ),
    );

    /** @var User $user */
    $user = User::query()->where('email', 'admin@cross.com')->firstOrFail();

    expect($user->name)
        ->toBe('Cross Admin')
        ->and($user->can(SystemPermission::Admin->value))
        ->toBeTrue()
        ->and($user->can(SystemPermission::DebtorsView->value))
        ->toBeTrue()
        ->and($user->can(SystemPermission::PreferencesUpdate->value))
        ->toBeTrue()
        ->and($user->ownedTeams()->count())
        ->toBe(1)
        ->and($user->currentTeam)
        ->not->toBeNull();
});

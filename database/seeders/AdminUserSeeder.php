<?php

declare(strict_types=1);

namespace Database\Seeders;

use Cross\Application\Admin\Data\AdminUserData;
use Cross\Application\Admin\EnsureAdminUser;
use Cross\Domain\Users\ValueObjects\UserEmail;
use Illuminate\Database\Seeder;

final class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        /** @var EnsureAdminUser $ensureAdminUser */
        $ensureAdminUser = app(EnsureAdminUser::class);

        $ensureAdminUser->handle(
            new AdminUserData(
                name: 'Cross Admin',
                email: new UserEmail('admin@cross.com'),
                password: 'cross',
            ),
        );
    }
}

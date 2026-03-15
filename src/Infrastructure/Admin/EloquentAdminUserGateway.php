<?php

declare(strict_types=1);

namespace Cross\Infrastructure\Admin;

use App\Models\Team;
use App\Models\User;
use Cross\Application\Admin\Contracts\AdminUserGateway;
use Cross\Application\Admin\Data\AdminUserData;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Domain\Teams\PersonalTeamName;
use Illuminate\Contracts\Hashing\Hasher;
use Spatie\Permission\Models\Permission;

final readonly class EloquentAdminUserGateway implements AdminUserGateway
{
    public function __construct(private Hasher $hasher) {}

    public function ensure(AdminUserData $adminUserData): void
    {
        Permission::findOrCreate(SystemPermission::Admin->value);
        Permission::findOrCreate(SystemPermission::DebtorsView->value);
        Permission::findOrCreate(SystemPermission::PreferencesUpdate->value);

        /** @var User $user */
        $user = User::query()->firstOrNew(['email' => $adminUserData->email->value]);

        $user->name = $adminUserData->name;
        $user->email = $adminUserData->email->value;
        $user->password = $this->hasher->make($adminUserData->password);
        $user->save();

        if ($user->ownedTeams()->count() === 0) {
            /** @var Team $team */
            $team = Team::forceCreate([
                'user_id' => $user->id,
                'name' => PersonalTeamName::fromOwnerName($user->name)->value,
                'personal_team' => true,
            ]);

            $user->forceFill(['current_team_id' => $team->id])->save();
        }

        $user->syncPermissions([
            SystemPermission::Admin->value,
            SystemPermission::DebtorsView->value,
            SystemPermission::PreferencesUpdate->value,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cross\Application\Admin;

use App\Models\User;
use App\Models\Team;
use Cross\Application\Admin\Data\AdminUserData;
use Cross\Domain\Security\Permissions\SystemPermission;
use Illuminate\Contracts\Hashing\Hasher;
use Spatie\Permission\Models\Permission;

final readonly class EnsureAdminUser
{
    public function __construct(private Hasher $hasher) {}

    public function handle(AdminUserData $adminUserData): User
    {
        Permission::findOrCreate(SystemPermission::Admin->value);
        Permission::findOrCreate(SystemPermission::HomeView->value);

        /** @var User $user */
        $user = User::query()->firstOrNew(['email' => $adminUserData->email->value]);

        $user->name = $adminUserData->name;
        $user->email = $adminUserData->email->value;
        $user->password = $this->hasher->make($adminUserData->password);
        $user->save();

        if ($user->ownedTeams()->count() === 0) {
            $team = Team::query()->create([
                'user_id' => $user->id,
                'name' => sprintf("%s's Team", $user->name),
                'personal_team' => true,
            ]);

            $user->forceFill(['current_team_id' => $team->id])->save();
        }

        $user->syncPermissions([SystemPermission::Admin->value, SystemPermission::HomeView->value]);

        return $user;
    }
}

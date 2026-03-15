<?php

declare(strict_types=1);

namespace Cross\Infrastructure\Authorization;

use App\Models\User;
use Cross\Application\Debtors\Contracts\UserPermissionChecker;
use Cross\Domain\Security\Permissions\SystemPermission;

final class SpatieUserPermissionChecker implements UserPermissionChecker
{
    public function hasPermission(int $userId, SystemPermission $permission): bool
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        return $user->can($permission->value);
    }
}

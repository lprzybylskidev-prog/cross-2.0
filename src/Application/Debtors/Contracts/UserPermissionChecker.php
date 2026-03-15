<?php

declare(strict_types=1);

namespace Cross\Application\Debtors\Contracts;

use Cross\Domain\Security\Permissions\SystemPermission;

interface UserPermissionChecker
{
    public function hasPermission(int $userId, SystemPermission $permission): bool;
}

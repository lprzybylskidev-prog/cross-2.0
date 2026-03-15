<?php

declare(strict_types=1);

namespace Cross\Application\Admin\Contracts;

use Cross\Application\Admin\Data\AdminUserData;

interface AdminUserGateway
{
    public function ensure(AdminUserData $adminUserData): void;
}

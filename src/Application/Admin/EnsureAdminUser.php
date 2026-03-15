<?php

declare(strict_types=1);

namespace Cross\Application\Admin;

use Cross\Application\Admin\Contracts\AdminUserGateway;
use Cross\Application\Admin\Data\AdminUserData;

final readonly class EnsureAdminUser
{
    public function __construct(private AdminUserGateway $adminUserGateway) {}

    public function handle(AdminUserData $adminUserData): void
    {
        $this->adminUserGateway->ensure($adminUserData);
    }
}

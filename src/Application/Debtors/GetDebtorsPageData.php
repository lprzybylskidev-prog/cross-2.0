<?php

declare(strict_types=1);

namespace Cross\Application\Debtors;

use Cross\Application\Debtors\Contracts\UserPermissionChecker;
use Cross\Domain\Security\Permissions\SystemPermission;

final readonly class GetDebtorsPageData
{
    public function __construct(private UserPermissionChecker $userPermissionChecker) {}

    /**
     * @return array{canViewDebtors: bool}
     */
    public function handle(?int $userId): array
    {
        return [
            'canViewDebtors' =>
                $userId !== null
                    ? $this->userPermissionChecker->hasPermission(
                        $userId,
                        SystemPermission::DebtorsView,
                    )
                    : false,
        ];
    }
}

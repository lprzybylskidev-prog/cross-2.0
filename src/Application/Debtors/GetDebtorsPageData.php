<?php

declare(strict_types=1);

namespace Cross\Application\Debtors;

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;

final class GetDebtorsPageData
{
    /**
     * @return array{canViewDebtors: bool}
     */
    public function handle(?User $user): array
    {
        return [
            'canViewDebtors' => $user?->can(SystemPermission::DebtorsView->value) ?? false,
        ];
    }
}

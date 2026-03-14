<?php

declare(strict_types=1);

namespace Cross\Application\Home;

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;

final class GetHomePageData
{
    /**
     * @return array{canViewHome: bool}
     */
    public function handle(?User $user): array
    {
        return [
            'canViewHome' => $user?->can(SystemPermission::HomeView->value) ?? false,
        ];
    }
}

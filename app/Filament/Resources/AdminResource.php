<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use Cross\Domain\Security\Permissions\SystemPermission;
use Filament\Resources\Resource;

abstract class AdminResource extends Resource
{
    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user !== null && $user->can(SystemPermission::Admin->value);
    }

    public static function canViewAny(): bool
    {
        return static::canAccess();
    }
}

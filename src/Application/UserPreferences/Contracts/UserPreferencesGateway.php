<?php

declare(strict_types=1);

namespace Cross\Application\UserPreferences\Contracts;

use Cross\Application\UserPreferences\Data\UserPreferencesData;

interface UserPreferencesGateway
{
    public function updatePreferences(int $userId, UserPreferencesData $preferencesData): void;
}

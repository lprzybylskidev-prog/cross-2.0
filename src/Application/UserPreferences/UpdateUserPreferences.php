<?php

declare(strict_types=1);

namespace Cross\Application\UserPreferences;

use Cross\Application\UserPreferences\Data\UserPreferencesData;
use Cross\Application\UserPreferences\Contracts\UserPreferencesGateway;

final readonly class UpdateUserPreferences
{
    public function __construct(private UserPreferencesGateway $userPreferencesGateway) {}

    public function handle(?int $userId, UserPreferencesData $preferencesData): void
    {
        if ($userId === null) {
            return;
        }

        $this->userPreferencesGateway->updatePreferences($userId, $preferencesData);
    }
}

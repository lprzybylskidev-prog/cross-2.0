<?php

declare(strict_types=1);

namespace Cross\Infrastructure\UserPreferences;

use App\Models\User;
use Cross\Application\UserPreferences\Contracts\UserPreferencesGateway;
use Cross\Application\UserPreferences\Data\UserPreferencesData;

final class EloquentUserPreferencesGateway implements UserPreferencesGateway
{
    public function updatePreferences(int $userId, UserPreferencesData $preferencesData): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        $user
            ->forceFill([
                'preferred_locale' => $preferencesData->locale->value,
                'preferred_theme' => $preferencesData->theme->value,
            ])
            ->save();
    }
}

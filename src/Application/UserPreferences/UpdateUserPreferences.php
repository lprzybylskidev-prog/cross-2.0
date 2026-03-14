<?php

declare(strict_types=1);

namespace Cross\Application\UserPreferences;

use App\Models\User;
use Cross\Application\UserPreferences\Data\UserPreferencesData;

final class UpdateUserPreferences
{
    public function handle(?User $user, UserPreferencesData $preferencesData): void
    {
        if ($user === null) {
            return;
        }

        $user
            ->forceFill([
                'preferred_locale' => $preferencesData->locale->value,
                'preferred_theme' => $preferencesData->theme->value,
            ])
            ->save();
    }
}

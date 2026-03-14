<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Application\UserPreferences\Data\UserPreferencesData;
use Cross\Application\UserPreferences\UpdateUserPreferences;
use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Users\Preferences\UserTheme;

it('updates user locale and theme preferences', function (): void {
    $user = User::factory()->create([
        'preferred_locale' => SystemLocale::Polish->value,
        'preferred_theme' => UserTheme::Dark->value,
    ]);

    $service = new UpdateUserPreferences();

    $service->handle(
        $user,
        new UserPreferencesData(locale: SystemLocale::English, theme: UserTheme::Light),
    );

    expect($user->refresh()->preferred_locale)
        ->toBe(SystemLocale::English->value)
        ->and($user->preferred_theme)
        ->toBe(UserTheme::Light->value);
});

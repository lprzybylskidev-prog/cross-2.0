<?php

declare(strict_types=1);

namespace Cross\Application\UserPreferences\Data;

use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Users\Preferences\UserTheme;

final readonly class UserPreferencesData
{
    public function __construct(public SystemLocale $locale, public UserTheme $theme) {}
}

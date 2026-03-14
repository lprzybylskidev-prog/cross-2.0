<?php

declare(strict_types=1);

namespace App\Http\Controllers\UserPreferences;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetApplicationPreferences;
use App\Http\Requests\UpdateUserPreferencesRequest;
use Cross\Application\UserPreferences\Data\UserPreferencesData;
use Cross\Application\UserPreferences\UpdateUserPreferences;
use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Users\Preferences\UserTheme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

final class UpdateUserPreferencesController extends Controller
{
    public function __invoke(
        UpdateUserPreferencesRequest $request,
        UpdateUserPreferences $updateUserPreferences,
    ): RedirectResponse {
        $preferencesData = new UserPreferencesData(
            locale: SystemLocale::fromNullable($request->string('locale')->toString()),
            theme: UserTheme::fromNullable($request->string('theme')->toString()),
        );

        $updateUserPreferences->handle($request->user(), $preferencesData);

        return back()
            ->withCookie(
                Cookie::make(
                    SetApplicationPreferences::LOCALE_COOKIE,
                    $preferencesData->locale->value,
                    60 * 24 * 365,
                ),
            )
            ->withCookie(
                Cookie::make(
                    SetApplicationPreferences::THEME_COOKIE,
                    $preferencesData->theme->value,
                    60 * 24 * 365,
                ),
            )
            ->with('flash.notification', [
                'type' => 'success',
                'message' => __('ui.flash.preferences_updated'),
            ]);
    }
}

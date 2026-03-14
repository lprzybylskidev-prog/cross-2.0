<?php

declare(strict_types=1);

use App\Http\Middleware\SetApplicationPreferences;
use App\Models\User;
use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Domain\Users\Preferences\UserTheme;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;

it('shares cookie based preferences for guest auth pages', function (): void {
    $response = $this->withCookie(
        SetApplicationPreferences::LOCALE_COOKIE,
        SystemLocale::English->value,
    )
        ->withCookie(SetApplicationPreferences::THEME_COOKIE, UserTheme::System->value)
        ->get('/login');

    $response->assertInertia(
        fn(AssertableInertia $page): AssertableInertia => $page
            ->where('locale', SystemLocale::English->value)
            ->where('preferences.locale', SystemLocale::English->value)
            ->where('preferences.theme', UserTheme::System->value),
    );
});

it('updates guest preferences and persists them in cookies', function (): void {
    $response = $this->from('/login')->put(route('preferences.update'), [
        'locale' => SystemLocale::English->value,
        'theme' => UserTheme::Light->value,
    ]);

    $response->assertRedirect('/login');
    $response->assertCookie(SetApplicationPreferences::LOCALE_COOKIE, SystemLocale::English->value);
    $response->assertCookie(SetApplicationPreferences::THEME_COOKIE, UserTheme::Light->value);
    $response->assertSessionHas(
        'flash.notification.message',
        __('ui.flash.preferences_updated', locale: SystemLocale::English->value),
    );
});

it('translates guest preference flash messages using the newly selected locale', function (): void {
    $response = $this
        ->withCookie(SetApplicationPreferences::LOCALE_COOKIE, SystemLocale::English->value)
        ->from('/login')
        ->put(route('preferences.update'), [
            'locale' => SystemLocale::Polish->value,
            'theme' => UserTheme::Light->value,
        ]);

    $response->assertRedirect('/login');
    $response->assertSessionHas(
        'flash.notification.message',
        __('ui.flash.preferences_updated', locale: SystemLocale::Polish->value),
    );
});

it(
    'forbids authenticated users without preferences permission from updating preferences',
    function (): void {
        $user = User::factory()->create();
        Permission::findOrCreate(SystemPermission::PreferencesUpdate->value, 'web');

        $response = $this->actingAs($user)->put(route('preferences.update'), [
            'locale' => SystemLocale::English->value,
            'theme' => UserTheme::Light->value,
        ]);

        $response->assertForbidden();
    },
);

it('updates authenticated user preferences and persists them in cookies', function (): void {
    $user = User::factory()->create();

    Permission::findOrCreate(SystemPermission::PreferencesUpdate->value, 'web');
    $user->givePermissionTo(SystemPermission::PreferencesUpdate->value);

    $response = $this->actingAs($user)
        ->from('/')
        ->put(route('preferences.update'), [
            'locale' => SystemLocale::English->value,
            'theme' => UserTheme::Light->value,
        ]);

    $response->assertRedirect('/');
    $response->assertCookie(SetApplicationPreferences::LOCALE_COOKIE, SystemLocale::English->value);
    $response->assertCookie(SetApplicationPreferences::THEME_COOKIE, UserTheme::Light->value);
    $response->assertSessionHas(
        'flash.notification.message',
        __('ui.flash.preferences_updated', locale: SystemLocale::English->value),
    );

    expect($user->refresh()->preferred_locale)
        ->toBe(SystemLocale::English->value)
        ->and($user->preferred_theme)
        ->toBe(UserTheme::Light->value);
});

it('translates authenticated preference flash messages using the newly selected locale', function (): void {
    $user = User::factory()->create([
        'preferred_locale' => SystemLocale::English->value,
    ]);

    Permission::findOrCreate(SystemPermission::PreferencesUpdate->value, 'web');
    $user->givePermissionTo(SystemPermission::PreferencesUpdate->value);

    $response = $this->actingAs($user)
        ->withCookie(SetApplicationPreferences::LOCALE_COOKIE, SystemLocale::English->value)
        ->from('/')
        ->put(route('preferences.update'), [
            'locale' => SystemLocale::Polish->value,
            'theme' => UserTheme::Light->value,
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHas(
        'flash.notification.message',
        __('ui.flash.preferences_updated', locale: SystemLocale::Polish->value),
    );
});

<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Users\Preferences\UserTheme;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Lang;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Crumb;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        $locale = SystemLocale::fromNullable(
            $user !== null
                ? $user->preferred_locale
                : $request->cookie(SetApplicationPreferences::LOCALE_COOKIE),
        );

        $theme = UserTheme::fromNullable(
            $user !== null
                ? $user->preferred_theme
                : $request->cookie(SetApplicationPreferences::THEME_COOKIE),
        );

        return [
            ...parent::share($request),
            'app' => [
                'name' => config('app.name'),
            ],
            'breadcrumbs' => $this->resolveBreadcrumbs($request),
            'locale' => $locale->value,
            'translations' => $this->resolveTranslations($locale),
            'preferences' => [
                'locale' => $locale->value,
                'theme' => $theme->value,
                'availableLocales' => SystemLocale::values(),
                'availableThemes' => UserTheme::values(),
            ],
            'flash' => [
                'notification' => $request->session()->get('flash.notification'),
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, url: string}>
     */
    private function resolveBreadcrumbs(Request $request): array
    {
        $routeName = $request->route()?->getName();

        if ($routeName === null) {
            return [];
        }

        if (Breadcrumbs::has($routeName)) {
            return Breadcrumbs::generate($routeName)
                ->map(
                    static fn(Crumb $breadcrumb): array => [
                        'title' => $breadcrumb->title(),
                        'url' => (string) $breadcrumb->url(),
                    ],
                )
                ->all();
        }

        return [
            [
                'title' => Str::of($routeName)
                    ->replace(['.', '-'], ' ')
                    ->title()
                    ->toString(),
                'url' => (string) $request->url(),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveTranslations(SystemLocale $locale): array
    {
        app()->setLocale($locale->value);

        $translations = Lang::get('ui');

        return is_array($translations) ? $translations : [];
    }
}

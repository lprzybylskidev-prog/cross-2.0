<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Cross\Domain\Localization\SystemLocale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetApplicationPreferences
{
    public const LOCALE_COOKIE = 'cross_locale';

    public const THEME_COOKIE = 'cross_theme';

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $locale = $user !== null ? $user->preferred_locale : $request->cookie(self::LOCALE_COOKIE);

        app()->setLocale(SystemLocale::fromNullable($locale)->value);

        return $next($request);
    }
}

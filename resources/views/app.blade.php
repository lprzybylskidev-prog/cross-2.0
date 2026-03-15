<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,700|manrope:400,500,600,700,800&display=swap"
            rel="stylesheet"
        />
        @routes
        @vite('resources/js/app.js')
        @inertiaHead
        <script>
            (() => {
                const match = document.cookie.match(/(?:^|;\s*)cross_theme=([^;]+)/);
                const themePreference = match ? decodeURIComponent(match[1]) : 'dark';
                const resolvedTheme =
                    themePreference === 'system'
                        ? window.matchMedia('(prefers-color-scheme: dark)').matches
                            ? 'dark'
                            : 'light'
                        : themePreference;

                document.documentElement.dataset.themePreference = themePreference;
                document.documentElement.dataset.theme = resolvedTheme;
            })();
        </script>
    </head>
    <body class="antialiased">
        @inertia
    </body>
</html>

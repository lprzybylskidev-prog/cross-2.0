<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'route_permission' => \App\Http\Middleware\EnsureRoutePermission::class,
        ]);

        $middleware->web(
            append: [
                \App\Http\Middleware\SetApplicationPreferences::class,
                \App\Http\Middleware\HandleInertiaRequests::class,
                \App\Http\Middleware\EnsureRoutePermission::class,
                \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            ],
        );

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();

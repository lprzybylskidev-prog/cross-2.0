<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Cross\Domain\Security\Permissions\SystemPermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

final class EnsureRoutePermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return $next($request);
        }

        if ($user->getAllPermissions()->contains('name', SystemPermission::Admin->value)) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if ($routeName === null) {
            return $next($request);
        }

        if (!Permission::query()->where('name', $routeName)->exists()) {
            return $next($request);
        }

        abort_unless($user->can($routeName), Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}

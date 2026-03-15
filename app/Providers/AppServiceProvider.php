<?php

declare(strict_types=1);

namespace App\Providers;

use Cross\Application\Admin\Contracts\AdminUserGateway;
use Cross\Application\Auth\Contracts\AuthUserGateway;
use Cross\Application\Debtors\Contracts\UserPermissionChecker;
use Cross\Application\Teams\Contracts\TeamGateway;
use Cross\Application\UserPreferences\Contracts\UserPreferencesGateway;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Infrastructure\Admin\EloquentAdminUserGateway;
use Cross\Infrastructure\Auth\EloquentAuthUserGateway;
use Cross\Infrastructure\Authorization\SpatieUserPermissionChecker;
use Cross\Infrastructure\Teams\JetstreamTeamGateway;
use Cross\Infrastructure\UserPreferences\EloquentUserPreferencesGateway;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminUserGateway::class, EloquentAdminUserGateway::class);
        $this->app->bind(AuthUserGateway::class, EloquentAuthUserGateway::class);
        $this->app->bind(UserPermissionChecker::class, SpatieUserPermissionChecker::class);
        $this->app->bind(TeamGateway::class, JetstreamTeamGateway::class);
        $this->app->bind(UserPreferencesGateway::class, EloquentUserPreferencesGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require base_path('routes/breadcrumbs.php');

        Gate::before(static function ($user): ?bool {
            if (!method_exists($user, 'getAllPermissions')) {
                return null;
            }

            return $user->getAllPermissions()->contains('name', SystemPermission::Admin->value)
                ? true
                : null;
        });
    }
}

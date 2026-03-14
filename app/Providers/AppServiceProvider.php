<?php

declare(strict_types=1);

namespace App\Providers;

use Cross\Domain\Security\Permissions\SystemPermission;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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

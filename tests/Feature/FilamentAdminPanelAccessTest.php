<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Spatie\Permission\Models\Permission;

function filamentAdminUrls(): array
{
    return [
        '/admin',
        '/admin/audit-entries',
        '/admin/cache-entries',
        '/admin/cache-locks',
        '/admin/failed-jobs',
        '/admin/job-batches',
        '/admin/jobs',
        '/admin/memberships',
        '/admin/migration-records',
        '/admin/model-has-permissions',
        '/admin/model-has-roles',
        '/admin/password-reset-tokens',
        '/admin/permissions',
        '/admin/personal-access-tokens',
        '/admin/role-has-permissions',
        '/admin/roles',
        '/admin/session-records',
        '/admin/team-invitations',
        '/admin/teams',
        '/admin/users',
    ];
}

it(
    'allows admin users to access the filament panel and all registered table resources',
    function (): void {
        $user = User::factory()->create();

        Permission::findOrCreate(SystemPermission::Admin->value, 'web');
        $user->givePermissionTo(SystemPermission::Admin->value);

        foreach (filamentAdminUrls() as $url) {
            $this->actingAs($user)->get($url)->assertSuccessful();
        }
    },
);

it(
    'returns forbidden for authenticated users without admin permission across the filament panel',
    function (): void {
        $user = User::factory()->create();

        foreach (filamentAdminUrls() as $url) {
            $this->actingAs($user)->get($url)->assertForbidden();
        }
    },
);

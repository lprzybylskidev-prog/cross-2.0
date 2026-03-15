<?php

declare(strict_types=1);

use App\Models\User;
use Cross\Domain\Security\Permissions\SystemPermission;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Filament\Resources\ModelHasPermissions\Pages\ManageModelHasPermissions;
use App\Filament\Resources\ModelHasRoles\Pages\ManageModelHasRoles;
use App\Filament\Resources\RoleHasPermissions\Pages\ManageRoleHasPermissions;

it(
    'shows role and direct permission management details on the filament users page',
    function (): void {
        config()->set('audit.console', true);

        $admin = User::factory()->create();
        Permission::findOrCreate(SystemPermission::Admin->value, 'web');
        $admin->givePermissionTo(SystemPermission::Admin->value);

        $role = Role::findOrCreate('support', 'web');
        $permission = Permission::findOrCreate('cases.view', 'web');

        $user = User::factory()->create([
            'name' => 'Alice Admin',
            'email' => 'alice@example.com',
        ]);

        $user->assignRole($role);
        $user->givePermissionTo($permission);

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertSuccessful()
            ->assertSeeText('Roles')
            ->assertSeeText('Direct permissions')
            ->assertSeeText('Alice Admin')
            ->assertSeeText('support')
            ->assertSeeText('cases.view');
    },
);

it('shows detailed audit metadata on the filament audit entries page', function (): void {
    config()->set('audit.console', true);

    $admin = User::factory()->create();
    Permission::findOrCreate(SystemPermission::Admin->value, 'web');
    $admin->givePermissionTo(SystemPermission::Admin->value);

    $auditedUser = User::factory()->create([
        'name' => 'Before Audit',
    ]);

    $auditedUser
        ->forceFill([
            'name' => 'After Audit',
        ])
        ->save();

    $this->actingAs($admin)
        ->get('/admin/audit-entries')
        ->assertSuccessful()
        ->assertSeeText('Auditable type')
        ->assertSeeText('Auditable ID')
        ->assertSeeText('Actor type')
        ->assertSeeText('IP address')
        ->assertSeeText('updated')
        ->assertSeeText($auditedUser::class);
});

it('shows useful operational data on the filament sessions page', function (): void {
    $admin = User::factory()->create();
    Permission::findOrCreate(SystemPermission::Admin->value, 'web');
    $admin->givePermissionTo(SystemPermission::Admin->value);

    $sessionUser = User::factory()->create([
        'name' => 'Session User',
        'email' => 'session@example.com',
    ]);

    DB::table('sessions')->insert([
        'id' => 'session-record-1',
        'user_id' => $sessionUser->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Pest Browser',
        'payload' => 'serialized-session-payload',
        'last_activity' => now()->timestamp,
    ]);

    $this->actingAs($admin)
        ->get('/admin/session-records')
        ->assertSuccessful()
        ->assertSeeText('User')
        ->assertSeeText('IP address')
        ->assertSeeText('Last activity')
        ->assertSeeText('session@example.com')
        ->assertSeeText('127.0.0.1');
});

it(
    'shows resolved role and permission names on the filament role permission pivot page',
    function (): void {
        $admin = User::factory()->create();
        Permission::findOrCreate(SystemPermission::Admin->value, 'web');
        $admin->givePermissionTo(SystemPermission::Admin->value);

        $role = Role::findOrCreate('manager', 'web');
        $permission = Permission::findOrCreate('reports.view', 'web');
        $role->givePermissionTo($permission);

        $this->actingAs($admin)
            ->get('/admin/role-has-permissions')
            ->assertSuccessful()
            ->assertSeeText('Permission')
            ->assertSeeText('Role')
            ->assertSeeText('reports.view')
            ->assertSeeText('manager');
    },
);

it('resolves composite-key spatie pivot records for filament table actions', function (): void {
    $admin = User::factory()->create();
    Permission::findOrCreate(SystemPermission::Admin->value, 'web');
    $admin->givePermissionTo(SystemPermission::Admin->value);

    $role = Role::findOrCreate('auditor', 'web');
    $permission = Permission::findOrCreate('users.review', 'web');
    $user = User::factory()->create();

    $user->givePermissionTo($permission);
    $user->assignRole($role);
    $role->givePermissionTo($permission);

    $this->actingAs($admin);

    Livewire::test(ManageModelHasPermissions::class)
        ->mountTableAction('view', $permission->id . ':' . User::class . ':' . $user->id)
        ->assertTableActionDataSet([
            'permission_id' => $permission->id,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

    Livewire::test(ManageModelHasRoles::class)
        ->mountTableAction('view', $role->id . ':' . User::class . ':' . $user->id)
        ->assertTableActionDataSet([
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

    Livewire::test(ManageRoleHasPermissions::class)
        ->mountTableAction('view', $permission->id . ':' . $role->id)
        ->assertTableActionDataSet([
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
});

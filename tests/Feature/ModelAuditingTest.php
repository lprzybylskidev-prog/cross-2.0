<?php

declare(strict_types=1);

use App\Models\Membership;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

it('records audits for all application models', function (): void {
    config()->set('audit.console', true);

    $user = User::factory()->create([
        'password' => 'secret-password',
    ]);

    $team = Team::factory()->create([
        'user_id' => $user->id,
        'personal_team' => false,
    ]);

    $invitation = $team->teamInvitations()->create([
        'email' => 'invitee@example.com',
        'role' => 'editor',
    ]);

    $member = User::factory()->create();
    $team->users()->attach($member, ['role' => 'editor']);

    $membership = Membership::query()
        ->where('team_id', $team->id)
        ->where('user_id', $member->id)
        ->firstOrFail();

    expect(
        Audit::query()
            ->where('auditable_type', $user::class)
            ->where('auditable_id', $user->id)
            ->exists(),
    )
        ->toBeTrue()
        ->and(
            Audit::query()
                ->where('auditable_type', $team::class)
                ->where('auditable_id', $team->id)
                ->exists(),
        )
        ->toBeTrue()
        ->and(
            Audit::query()
                ->where('auditable_type', $invitation::class)
                ->where('auditable_id', $invitation->id)
                ->exists(),
        )
        ->toBeTrue()
        ->and(
            Audit::query()
                ->where('auditable_type', $membership::class)
                ->where('auditable_id', $membership->id)
                ->exists(),
        )
        ->toBeTrue();
});

it('does not store user secrets in audit payloads', function (): void {
    config()->set('audit.console', true);

    $user = User::factory()->create([
        'password' => 'super-secret-password',
    ]);

    /** @var Audit $audit */
    $audit = Audit::query()
        ->where('auditable_type', $user::class)
        ->where('auditable_id', $user->id)
        ->latest('id')
        ->firstOrFail();

    expect($audit->new_values)->not->toHaveKeys([
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ]);
});

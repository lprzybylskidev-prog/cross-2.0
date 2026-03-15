<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Mail\TeamInvitation;

test('team members can be invited to team', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/teams/' . $user->currentTeam->id . '/members', [
        'email' => 'test@example.com',
        'role' => 'admin',
    ]);

    Mail::assertSent(TeamInvitation::class);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(1);
})->skip(function () {
    return !Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');

test('team member invitations can be cancelled', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $invitation = $user->currentTeam->teamInvitations()->create([
        'email' => 'test@example.com',
        'role' => 'admin',
    ]);

    $this->delete('/team-invitations/' . $invitation->id);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(0);
})->skip(function () {
    return !Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');

test('team invitation email uses the shared transactional layout', function () {
    App::setLocale('en');

    $user = User::factory()->withPersonalTeam()->create();

    $invitation = $user->currentTeam
        ->teamInvitations()
        ->create([
            'email' => 'invitee@example.com',
            'role' => 'admin',
        ])
        ->fresh('team');

    $renderedMail = (new TeamInvitation($invitation))->render();

    expect($renderedMail)
        ->toContain('mail-shell__brand')
        ->toContain('mail-shell__panel')
        ->toContain('Operational workspace')
        ->toContain('You have been invited to join the')
        ->not->toContain('background: #313244');
})->skip(function () {
    return !Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');

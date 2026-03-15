<?php

declare(strict_types=1);

namespace Cross\Infrastructure\Teams;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use Cross\Application\Teams\Contracts\TeamGateway;
use Cross\Domain\Teams\TeamName;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Events\TeamMemberRemoved;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation as TeamInvitationMail;

final class JetstreamTeamGateway implements TeamGateway
{
    public function createTeam(int $userId, TeamName $teamName): int
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());
        AddingTeam::dispatch($user);

        /** @var Team $team */
        $team = $user->ownedTeams()->create([
            'name' => $teamName->value,
            'personal_team' => false,
        ]);

        $user->switchTeam($team);

        return $team->getKey();
    }

    public function updateTeamName(int $userId, int $teamId, TeamName $teamName): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);
        /** @var Team $team */
        $team = Team::query()->findOrFail($teamId);

        Gate::forUser($user)->authorize('update', $team);

        $team
            ->forceFill([
                'name' => $teamName->value,
            ])
            ->save();
    }

    public function addTeamMember(int $userId, int $teamId, string $email, ?string $role): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);
        /** @var Team $team */
        $team = Team::query()->findOrFail($teamId);

        Gate::forUser($user)->authorize('addTeamMember', $team);

        $newTeamMember = Jetstream::findUserByEmailOrFail($email);

        AddingTeamMember::dispatch($team, $newTeamMember);

        $team->users()->attach($newTeamMember, ['role' => $role]);

        TeamMemberAdded::dispatch($team, $newTeamMember);
    }

    public function inviteTeamMember(int $userId, int $teamId, string $email, ?string $role): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);
        /** @var Team $team */
        $team = Team::query()->findOrFail($teamId);

        Gate::forUser($user)->authorize('addTeamMember', $team);

        InvitingTeamMember::dispatch($team, $email, $role);

        /** @var TeamInvitation $invitation */
        $invitation = $team->teamInvitations()->create([
            'email' => $email,
            'role' => $role,
        ]);

        Mail::to($email)->send(new TeamInvitationMail($invitation));
    }

    public function removeTeamMember(int $userId, int $teamId, int $teamMemberId): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);
        /** @var Team $team */
        $team = Team::query()->findOrFail($teamId);
        /** @var User $teamMember */
        $teamMember = User::query()->findOrFail($teamMemberId);

        if (
            !Gate::forUser($user)->check('removeTeamMember', $team) &&
            $user->id !== $teamMember->id
        ) {
            throw new AuthorizationException();
        }

        $ownerId = (int) $team->getAttribute('user_id');

        if ($teamMember->id === $ownerId) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ])->errorBag('removeTeamMember');
        }

        $team->removeUser($teamMember);

        TeamMemberRemoved::dispatch($team, $teamMember);
    }

    public function deleteTeam(int $teamId): void
    {
        /** @var Team $team */
        $team = Team::query()->findOrFail($teamId);

        $team->purge();
    }

    public function deleteUser(int $userId): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        DB::transaction(function () use ($user): void {
            $user->teams()->detach();

            /** @var \Illuminate\Database\Eloquent\Collection<int, Team> $ownedTeams */
            $ownedTeams = $user->ownedTeams;

            $ownedTeams->each(function (Team $team): void {
                $this->deleteTeam($team->getKey());
            });

            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });
    }
}

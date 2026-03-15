<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Closure;
use Cross\Application\Teams\InviteTeamMember as InviteTeamMemberUseCase;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class InviteTeamMember implements InvitesTeamMembers
{
    public function __construct(private readonly InviteTeamMemberUseCase $inviteTeamMember) {}

    /**
     * Invite a new team member to the given team.
     */
    public function invite(User $user, Team $team, string $email, ?string $role = null): void
    {
        $this->validate($team, $email, $role);

        $this->inviteTeamMember->handle($user->getKey(), $team->getKey(), $email, $role);
    }

    /**
     * Validate the invite member operation.
     */
    protected function validate(Team $team, string $email, ?string $role): void
    {
        Validator::make(
            [
                'email' => $email,
                'role' => $role,
            ],
            $this->rules($team),
            [
                'email.unique' => __('This user has already been invited to the team.'),
            ],
        )
            ->after($this->ensureUserIsNotAlreadyOnTeam($team, $email))
            ->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for inviting a team member.
     *
     * @return array{
     *     email: list<object|string>,
     *     role?: list<object|string>
     * }
     */
    protected function rules(Team $team): array
    {
        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique(Jetstream::teamInvitationModel())->where(function (
                    Builder $query,
                ) use ($team) {
                    $query->where('team_id', $team->id);
                }),
            ],
        ];

        if (Jetstream::hasRoles()) {
            $rules['role'] = ['required', 'string', new Role()];
        }

        return $rules;
    }

    /**
     * Ensure that the user is not already on the team.
     */
    protected function ensureUserIsNotAlreadyOnTeam(Team $team, string $email): Closure
    {
        return function ($validator) use ($team, $email) {
            $validator
                ->errors()
                ->addIf(
                    $team->hasUserWithEmail($email),
                    'email',
                    __('This user already belongs to the team.'),
                );
        };
    }
}

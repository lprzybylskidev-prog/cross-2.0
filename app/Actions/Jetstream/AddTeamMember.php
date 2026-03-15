<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Closure;
use Cross\Application\Teams\AddTeamMember as AddTeamMemberUseCase;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddTeamMember implements AddsTeamMembers
{
    public function __construct(private readonly AddTeamMemberUseCase $addTeamMember) {}

    /**
     * Add a new team member to the given team.
     */
    public function add(User $user, Team $team, string $email, ?string $role = null): void
    {
        $this->validate($team, $email, $role);

        $this->addTeamMember->handle($user->getKey(), $team->getKey(), $email, $role);
    }

    /**
     * Validate the add member operation.
     */
    protected function validate(Team $team, string $email, ?string $role): void
    {
        Validator::make(
            [
                'email' => $email,
                'role' => $role,
            ],
            $this->rules(),
            [
                'email.exists' => __(
                    'We were unable to find a registered user with this email address.',
                ),
            ],
        )
            ->after($this->ensureUserIsNotAlreadyOnTeam($team, $email))
            ->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for adding a team member.
     *
     * @return array<string, list<Rule|string>>
     */
    protected function rules(): array
    {
        return array_filter([
            'email' => ['required', 'email', 'exists:users'],
            'role' => Jetstream::hasRoles() ? ['required', 'string', new Role()] : null,
        ]);
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

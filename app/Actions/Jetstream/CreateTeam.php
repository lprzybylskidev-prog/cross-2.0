<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Cross\Application\Teams\CreateTeam as CreateTeamUseCase;
use Cross\Domain\Teams\TeamName;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;

class CreateTeam implements CreatesTeams
{
    public function __construct(private readonly CreateTeamUseCase $createTeam) {}

    /**
     * Validate and create a new team for the given user.
     *
     * @param  array<string, string>  $input
     */
    public function create(User $user, array $input): Team
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        $teamId = $this->createTeam->handle($user->getKey(), new TeamName($input['name']));

        /** @var Team $team */
        $team = Team::query()->findOrFail($teamId);

        return $team;
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Cross\Application\Teams\UpdateTeamName as UpdateTeamNameUseCase;
use Cross\Domain\Teams\TeamName;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
    public function __construct(private readonly UpdateTeamNameUseCase $updateTeamName) {}

    /**
     * Validate and update the given team's name.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, Team $team, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTeamName');

        $this->updateTeamName->handle(
            $user->getKey(),
            $team->getKey(),
            new TeamName($input['name']),
        );
    }
}

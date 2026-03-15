<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use Cross\Application\Teams\DeleteTeam as DeleteTeamUseCase;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    public function __construct(private readonly DeleteTeamUseCase $deleteTeam) {}

    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        $this->deleteTeam->handle($team->getKey());
    }
}

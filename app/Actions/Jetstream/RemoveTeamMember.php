<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Cross\Application\Teams\RemoveTeamMember as RemoveTeamMemberUseCase;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;

class RemoveTeamMember implements RemovesTeamMembers
{
    public function __construct(private readonly RemoveTeamMemberUseCase $removeTeamMember) {}

    /**
     * Remove the team member from the given team.
     */
    public function remove(User $user, Team $team, User $teamMember): void
    {
        $this->removeTeamMember->handle($user->getKey(), $team->getKey(), $teamMember->getKey());
    }
}

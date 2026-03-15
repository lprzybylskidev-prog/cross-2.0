<?php

declare(strict_types=1);

namespace Cross\Application\Teams;

use Cross\Application\Teams\Contracts\TeamGateway;
use Cross\Domain\Teams\TeamName;

final readonly class UpdateTeamName
{
    public function __construct(private TeamGateway $teamGateway) {}

    public function handle(int $userId, int $teamId, TeamName $teamName): void
    {
        $this->teamGateway->updateTeamName($userId, $teamId, $teamName);
    }
}

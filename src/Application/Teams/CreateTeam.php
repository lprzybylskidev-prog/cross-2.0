<?php

declare(strict_types=1);

namespace Cross\Application\Teams;

use Cross\Application\Teams\Contracts\TeamGateway;
use Cross\Domain\Teams\TeamName;

final readonly class CreateTeam
{
    public function __construct(private TeamGateway $teamGateway) {}

    public function handle(int $userId, TeamName $teamName): int
    {
        return $this->teamGateway->createTeam($userId, $teamName);
    }
}

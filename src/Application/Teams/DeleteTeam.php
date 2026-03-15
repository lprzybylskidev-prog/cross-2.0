<?php

declare(strict_types=1);

namespace Cross\Application\Teams;

use Cross\Application\Teams\Contracts\TeamGateway;

final readonly class DeleteTeam
{
    public function __construct(private TeamGateway $teamGateway) {}

    public function handle(int $teamId): void
    {
        $this->teamGateway->deleteTeam($teamId);
    }
}

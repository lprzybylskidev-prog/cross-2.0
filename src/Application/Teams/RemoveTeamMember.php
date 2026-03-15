<?php

declare(strict_types=1);

namespace Cross\Application\Teams;

use Cross\Application\Teams\Contracts\TeamGateway;

final readonly class RemoveTeamMember
{
    public function __construct(private TeamGateway $teamGateway) {}

    public function handle(int $userId, int $teamId, int $teamMemberId): void
    {
        $this->teamGateway->removeTeamMember($userId, $teamId, $teamMemberId);
    }
}

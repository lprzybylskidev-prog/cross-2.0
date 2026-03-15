<?php

declare(strict_types=1);

namespace Cross\Application\Teams;

use Cross\Application\Teams\Contracts\TeamGateway;

final readonly class AddTeamMember
{
    public function __construct(private TeamGateway $teamGateway) {}

    public function handle(int $userId, int $teamId, string $email, ?string $role = null): void
    {
        $this->teamGateway->addTeamMember($userId, $teamId, $email, $role);
    }
}

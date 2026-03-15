<?php

declare(strict_types=1);

namespace Cross\Application\Teams;

use Cross\Application\Teams\Contracts\TeamGateway;

final readonly class DeleteUser
{
    public function __construct(private TeamGateway $teamGateway) {}

    public function handle(int $userId): void
    {
        $this->teamGateway->deleteUser($userId);
    }
}

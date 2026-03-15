<?php

declare(strict_types=1);

namespace Cross\Application\Teams\Contracts;

use Cross\Domain\Teams\TeamName;

interface TeamGateway
{
    public function createTeam(int $userId, TeamName $teamName): int;

    public function updateTeamName(int $userId, int $teamId, TeamName $teamName): void;

    public function addTeamMember(int $userId, int $teamId, string $email, ?string $role): void;

    public function inviteTeamMember(int $userId, int $teamId, string $email, ?string $role): void;

    public function removeTeamMember(int $userId, int $teamId, int $teamMemberId): void;

    public function deleteTeam(int $teamId): void;

    public function deleteUser(int $userId): void;
}

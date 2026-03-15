<?php

declare(strict_types=1);

namespace Cross\Application\Auth\Contracts;

use Cross\Application\Auth\Data\NewUserData;
use Cross\Application\Auth\Data\ProfileInformationData;

interface AuthUserGateway
{
    public function register(NewUserData $data): int;

    public function updateProfileInformation(int $userId, ProfileInformationData $data): void;

    public function updatePassword(int $userId, string $password): void;
}

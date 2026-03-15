<?php

declare(strict_types=1);

namespace Cross\Application\Auth;

use Cross\Application\Auth\Contracts\AuthUserGateway;
use Cross\Application\Auth\Data\ProfileInformationData;

final readonly class UpdateUserProfileInformation
{
    public function __construct(private AuthUserGateway $authUserGateway) {}

    public function handle(int $userId, ProfileInformationData $data): void
    {
        $this->authUserGateway->updateProfileInformation($userId, $data);
    }
}

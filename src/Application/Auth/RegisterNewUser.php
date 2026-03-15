<?php

declare(strict_types=1);

namespace Cross\Application\Auth;

use Cross\Application\Auth\Contracts\AuthUserGateway;
use Cross\Application\Auth\Data\NewUserData;

final readonly class RegisterNewUser
{
    public function __construct(private AuthUserGateway $authUserGateway) {}

    public function handle(NewUserData $data): int
    {
        return $this->authUserGateway->register($data);
    }
}

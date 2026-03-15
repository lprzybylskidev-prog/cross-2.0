<?php

declare(strict_types=1);

namespace Cross\Application\Auth;

use Cross\Application\Auth\Contracts\AuthUserGateway;

final readonly class ResetUserPassword
{
    public function __construct(private AuthUserGateway $authUserGateway) {}

    public function handle(int $userId, string $password): void
    {
        $this->authUserGateway->updatePassword($userId, $password);
    }
}

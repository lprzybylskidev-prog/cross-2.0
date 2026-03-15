<?php

declare(strict_types=1);

namespace Cross\Application\Auth\Data;

use Cross\Domain\Users\ValueObjects\UserEmail;

final readonly class NewUserData
{
    public function __construct(
        public string $name,
        public UserEmail $email,
        public string $password,
    ) {}
}

<?php

declare(strict_types=1);

namespace Cross\Application\Admin\Data;

use Cross\Domain\Users\ValueObjects\UserEmail;

final readonly class AdminUserData
{
    public function __construct(
        public string $name,
        public UserEmail $email,
        public string $password,
    ) {}
}

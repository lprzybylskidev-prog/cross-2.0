<?php

declare(strict_types=1);

namespace Cross\Domain\Users\ValueObjects;

use InvalidArgumentException;

final readonly class UserEmail
{
    public function __construct(public string $value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid email address.');
        }
    }
}

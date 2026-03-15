<?php

declare(strict_types=1);

namespace Cross\Domain\Teams;

use InvalidArgumentException;

final readonly class TeamName
{
    public string $value;

    public function __construct(string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw new InvalidArgumentException('Team name cannot be empty.');
        }

        if (mb_strlen($normalizedValue) > 255) {
            throw new InvalidArgumentException('Team name cannot exceed 255 characters.');
        }

        $this->value = $normalizedValue;
    }
}

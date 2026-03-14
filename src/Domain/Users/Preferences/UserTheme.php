<?php

declare(strict_types=1);

namespace Cross\Domain\Users\Preferences;

enum UserTheme: string
{
    case Dark = 'dark';
    case Light = 'light';
    case System = 'system';

    public static function default(): self
    {
        return self::Dark;
    }

    public static function fromNullable(?string $value): self
    {
        return self::tryFrom((string) $value) ?? self::default();
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn(self $theme): string => $theme->value, self::cases());
    }
}

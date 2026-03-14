<?php

declare(strict_types=1);

namespace Cross\Domain\Localization;

enum SystemLocale: string
{
    case Polish = 'pl';
    case English = 'en';

    public static function default(): self
    {
        return self::Polish;
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
        return array_map(static fn(self $locale): string => $locale->value, self::cases());
    }
}

<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

trait HasCompositeFilamentKey
{
    /**
     * @return array<int, string>
     */
    abstract protected static function getCompositeKeyColumns(): array;

    public function getKey(): string
    {
        return static::encodeCompositeKey($this);
    }

    /**
     * @param  Model|array<string, mixed>  $record
     */
    public static function encodeCompositeKey(Model|array $record): string
    {
        $attributes = $record instanceof Model ? $record->getAttributes() : $record;

        return implode(
            ':',
            array_map(
                static fn(string $column): string => (string) ($attributes[$column] ?? ''),
                static::getCompositeKeyColumns(),
            ),
        );
    }

    /**
     * @return array<string, string>
     */
    protected static function decodeCompositeKey(string $key): array
    {
        $columns = static::getCompositeKeyColumns();
        $segments = explode(':', $key);

        if (count($segments) !== count($columns)) {
            throw new InvalidArgumentException(
                sprintf('Invalid composite Filament key [%s] for model [%s].', $key, static::class),
            );
        }

        /** @var array<string, string> $decoded */
        $decoded = array_combine($columns, $segments);

        return $decoded;
    }

    /**
     * @param  Builder<Model>  $query
     */
    public static function resolveFilamentRecord(Builder $query, string $key): ?Model
    {
        foreach (static::decodeCompositeKey($key) as $column => $value) {
            $query->where($column, $value);
        }

        return $query->first();
    }
}

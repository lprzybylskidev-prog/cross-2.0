<?php

declare(strict_types=1);

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ResolvesCompositeFilamentRecord
{
    /**
     * @param  Builder<Model>  $query
     */
    public static function resolveFilamentRecord(Builder $query, string $key): ?Model;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\CacheEntries\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\CacheEntries\CacheEntryResource;

class ManageCacheEntries extends ReadOnlyManageRecords
{
    protected static string $resource = CacheEntryResource::class;
}

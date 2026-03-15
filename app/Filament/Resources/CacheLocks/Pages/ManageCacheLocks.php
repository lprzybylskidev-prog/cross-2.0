<?php

declare(strict_types=1);

namespace App\Filament\Resources\CacheLocks\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\CacheLocks\CacheLockResource;

class ManageCacheLocks extends ReadOnlyManageRecords
{
    protected static string $resource = CacheLockResource::class;
}

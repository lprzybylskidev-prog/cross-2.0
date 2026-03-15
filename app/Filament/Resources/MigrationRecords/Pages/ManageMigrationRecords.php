<?php

declare(strict_types=1);

namespace App\Filament\Resources\MigrationRecords\Pages;

use App\Filament\Resources\MigrationRecords\MigrationRecordResource;
use App\Filament\Resources\Pages\ReadOnlyManageRecords;

class ManageMigrationRecords extends ReadOnlyManageRecords
{
    protected static string $resource = MigrationRecordResource::class;
}

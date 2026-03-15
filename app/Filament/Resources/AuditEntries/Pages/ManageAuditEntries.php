<?php

declare(strict_types=1);

namespace App\Filament\Resources\AuditEntries\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\AuditEntries\AuditEntryResource;

class ManageAuditEntries extends ReadOnlyManageRecords
{
    protected static string $resource = AuditEntryResource::class;
}

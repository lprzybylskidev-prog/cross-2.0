<?php

declare(strict_types=1);

namespace App\Filament\Resources\SessionRecords\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\SessionRecords\SessionRecordResource;

class ManageSessionRecords extends ReadOnlyManageRecords
{
    protected static string $resource = SessionRecordResource::class;
}

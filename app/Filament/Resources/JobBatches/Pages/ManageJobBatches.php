<?php

declare(strict_types=1);

namespace App\Filament\Resources\JobBatches\Pages;

use App\Filament\Resources\JobBatches\JobBatchResource;
use App\Filament\Resources\Pages\ReadOnlyManageRecords;

class ManageJobBatches extends ReadOnlyManageRecords
{
    protected static string $resource = JobBatchResource::class;
}

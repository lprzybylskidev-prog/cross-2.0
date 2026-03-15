<?php

declare(strict_types=1);

namespace App\Filament\Resources\FailedJobs\Pages;

use App\Filament\Resources\FailedJobs\FailedJobResource;
use App\Filament\Resources\Pages\ReadOnlyManageRecords;

class ManageFailedJobs extends ReadOnlyManageRecords
{
    protected static string $resource = FailedJobResource::class;
}

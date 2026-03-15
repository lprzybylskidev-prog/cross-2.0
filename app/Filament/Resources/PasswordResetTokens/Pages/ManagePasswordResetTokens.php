<?php

declare(strict_types=1);

namespace App\Filament\Resources\PasswordResetTokens\Pages;

use App\Filament\Resources\Pages\ReadOnlyManageRecords;
use App\Filament\Resources\PasswordResetTokens\PasswordResetTokenResource;

class ManagePasswordResetTokens extends ReadOnlyManageRecords
{
    protected static string $resource = PasswordResetTokenResource::class;
}

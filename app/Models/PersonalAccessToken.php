<?php

declare(strict_types=1);

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * @return MorphTo<\Illuminate\Database\Eloquent\Model, $this>
     */
    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
}

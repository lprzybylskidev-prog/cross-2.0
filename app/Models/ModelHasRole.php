<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelHasRole extends Model
{
    protected $table = 'model_has_roles';

    protected $primaryKey = 'role_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    /**
     * @return BelongsTo<Role, $this>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getKey(): string
    {
        return implode(':', [
            (string) $this->getAttribute('role_id'),
            (string) $this->getAttribute('model_type'),
            (string) $this->getAttribute('model_id'),
        ]);
    }
}

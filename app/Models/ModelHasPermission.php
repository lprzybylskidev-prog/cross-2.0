<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelHasPermission extends Model
{
    protected $table = 'model_has_permissions';

    protected $primaryKey = 'permission_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    /**
     * @return BelongsTo<Permission, $this>
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function getKey(): string
    {
        return implode(':', [
            (string) $this->getAttribute('permission_id'),
            (string) $this->getAttribute('model_type'),
            (string) $this->getAttribute('model_id'),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleHasPermission extends Model
{
    protected $table = 'role_has_permissions';

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
            (string) $this->getAttribute('permission_id'),
            (string) $this->getAttribute('role_id'),
        ]);
    }
}

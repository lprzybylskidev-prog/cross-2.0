<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasCompositeFilamentKey;
use App\Models\Contracts\ResolvesCompositeFilamentRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelHasPermission extends Model implements ResolvesCompositeFilamentRecord
{
    use HasCompositeFilamentKey;

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

    /**
     * @return array<int, string>
     */
    protected static function getCompositeKeyColumns(): array
    {
        return ['permission_id', 'model_type', 'model_id'];
    }
}

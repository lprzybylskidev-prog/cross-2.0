<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasCompositeFilamentKey;
use App\Models\Contracts\ResolvesCompositeFilamentRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelHasRole extends Model implements ResolvesCompositeFilamentRecord
{
    use HasCompositeFilamentKey;

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

    /**
     * @return array<int, string>
     */
    protected static function getCompositeKeyColumns(): array
    {
        return ['role_id', 'model_type', 'model_id'];
    }
}

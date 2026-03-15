<?php

declare(strict_types=1);

namespace App\Models;

use Laravel\Jetstream\Membership as JetstreamMembership;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Membership extends JetstreamMembership implements Auditable
{
    use AuditableTrait;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}

<?php

declare(strict_types=1);

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

Breadcrumbs::for('home.view', static function (Trail $trail): void {
    $trail->push('Home', route('home.view'));
});

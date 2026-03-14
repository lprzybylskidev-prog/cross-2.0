<?php

declare(strict_types=1);

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

Breadcrumbs::for('debtors.view', static function (Trail $trail): void {
    $trail->push(__('ui.debtors.title'), route('debtors.view'));
});

Breadcrumbs::for('profile.show', static function (Trail $trail): void {
    $trail->push(__('ui.profile.title'), route('profile.show'));
});

<?php

declare(strict_types=1);

namespace Cross\Domain\Security\Permissions;

enum SystemPermission: string
{
    case Admin = 'admin';
    case HomeView = 'home.view';
}

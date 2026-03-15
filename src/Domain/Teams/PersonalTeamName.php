<?php

declare(strict_types=1);

namespace Cross\Domain\Teams;

final class PersonalTeamName
{
    public static function fromOwnerName(string $ownerName): TeamName
    {
        $normalizedName = trim($ownerName);
        $firstName = strtok($normalizedName, ' ');
        $label = $firstName !== false && $firstName !== '' ? $firstName : 'User';

        return new TeamName(sprintf("%s's Team", $label));
    }
}

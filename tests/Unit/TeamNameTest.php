<?php

declare(strict_types=1);

use Cross\Domain\Teams\PersonalTeamName;
use Cross\Domain\Teams\TeamName;

it('normalizes valid team names', function (): void {
    $teamName = new TeamName('  Operations  ');

    expect($teamName->value)->toBe('Operations');
});

it('builds a personal team name from the owner name', function (): void {
    $teamName = PersonalTeamName::fromOwnerName('Jane Doe');

    expect($teamName->value)->toBe("Jane's Team");
});

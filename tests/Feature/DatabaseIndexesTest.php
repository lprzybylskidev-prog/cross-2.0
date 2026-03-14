<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;

it('adds indexes required by current team and session queries', function (): void {
    $userIndexes = collect(Schema::getIndexes('users'));
    $sessionIndexes = collect(Schema::getIndexes('sessions'));

    expect(
        $userIndexes->contains(
            fn(array $index): bool => $index['columns'] === ['current_team_id'] &&
                $index['primary'] === false &&
                $index['unique'] === false,
        ),
    )
        ->toBeTrue()
        ->and(
            $sessionIndexes->contains(
                fn(array $index): bool => $index['columns'] === ['user_id', 'last_activity'] &&
                    $index['primary'] === false &&
                    $index['unique'] === false,
            ),
        )
        ->toBeTrue();
});

it('adds a dedicated user index for team membership queries', function (): void {
    $teamUserIndexes = collect(Schema::getIndexes('team_user'));

    expect(
        $teamUserIndexes->contains(
            fn(array $index): bool => $index['columns'] === ['user_id'] &&
                $index['primary'] === false &&
                $index['unique'] === false,
        ),
    )
        ->toBeTrue()
        ->and(
            $teamUserIndexes->contains(
                fn(array $index): bool => $index['columns'] === ['team_id', 'user_id'] &&
                    $index['primary'] === false &&
                    $index['unique'] === true,
            ),
        )
        ->toBeTrue();
});

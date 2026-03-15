<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

it('shares the app name from the environment file with inertia pages', function (): void {
    $response = $this->get('/login');

    $response->assertInertia(
        fn(AssertableInertia $page): AssertableInertia => $page->where('app.name', 'Cross 2.0'),
    );
});

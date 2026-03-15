<?php

declare(strict_types=1);

/**
 * Ensure test-only environment values override container-level variables.
 */
$databasePath = tempnam(sys_get_temp_dir(), 'cross-tests-');

if ($databasePath === false) {
    throw new \RuntimeException('Unable to create a temporary SQLite database for tests.');
}

register_shutdown_function(static function () use ($databasePath): void {
    if (is_file($databasePath)) {
        @unlink($databasePath);
    }
});

$variables = [
    'APP_ENV' => 'testing',
    'APP_MAINTENANCE_DRIVER' => 'file',
    'BCRYPT_ROUNDS' => '4',
    'BROADCAST_CONNECTION' => 'null',
    'CACHE_STORE' => 'array',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => $databasePath,
    'DB_URL' => '',
    'MAIL_MAILER' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'SESSION_DRIVER' => 'array',
    'PULSE_ENABLED' => 'false',
    'TELESCOPE_ENABLED' => 'false',
    'NIGHTWATCH_ENABLED' => 'false',
];

foreach ($variables as $name => $value) {
    putenv(sprintf('%s=%s', $name, $value));
    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}

require __DIR__ . '/../vendor/autoload.php';

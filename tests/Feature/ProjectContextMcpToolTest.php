<?php

declare(strict_types=1);

use App\Mcp\Tools\ProjectContext;
use Laravel\Boost\Mcp\ToolRegistry;
use Laravel\Mcp\Request;

it('registers the custom boost context tool', function (): void {
    ToolRegistry::clearCache();

    expect(ToolRegistry::getToolNames())->toHaveKey('ProjectContext');
});

it('returns project context for ai agents', function (): void {
    $tool = app(ProjectContext::class);

    $response = $tool->handle(new Request());
    $payload = json_decode((string) $response->content(), true, 512, JSON_THROW_ON_ERROR);

    expect($response->isError())
        ->toBeFalse()
        ->and($payload)
        ->toHaveKeys([
            'routes',
            'configuration_files',
            'models',
            'artisan_commands',
            'environment',
            'database',
            'logs',
        ])
        ->and($payload['configuration_files'])
        ->toContain('config/app.php')
        ->and($payload['artisan_commands'])
        ->not->toBeEmpty()
        ->and($payload['routes'])
        ->not->toBeEmpty()
        ->and($payload['database']['schema_tool'])
        ->toBe('DatabaseSchema')
        ->and($payload['logs']['tools'])
        ->toBe(['ReadLogEntries', 'LastError', 'BrowserLogs']);
});

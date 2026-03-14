<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Boost\Install\GuidelineAssist;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

#[IsReadOnly]
class ProjectContext extends Tool
{
    public function __construct(private readonly GuidelineAssist $guidelineAssist)
    {
    }

    protected string $description = 'Get project context tailored for AI agents, including application routes, configuration files, Eloquent models, Artisan commands, environment summary, and the Boost tools used for schema and log inspection.';

    public function handle(Request $request): Response
    {
        return Response::json([
            'routes' => $this->routes(),
            'configuration_files' => $this->configurationFiles(),
            'models' => array_keys($this->guidelineAssist->models()),
            'artisan_commands' => $this->artisanCommands(),
            'environment' => $this->environment(),
            'database' => [
                'default_connection' => config('database.default'),
                'connections' => array_keys(config('database.connections', [])),
                'schema_tool' => 'DatabaseSchema',
                'query_tool' => 'DatabaseQuery',
            ],
            'logs' => [
                'default_channel' => config('logging.default'),
                'application_log_path' => storage_path('logs/laravel.log'),
                'browser_log_path' => storage_path('logs/browser.log'),
                'tools' => [
                    'ReadLogEntries',
                    'LastError',
                    'BrowserLogs',
                ],
            ],
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function routes(): array
    {
        return collect(Route::getRoutes()->getRoutes())
            ->map(fn ($route): array => [
                'methods' => array_values(array_diff($route->methods(), ['HEAD'])),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'middleware' => $route->gatherMiddleware(),
            ])
            ->sortBy([
                ['uri', 'asc'],
                ['name', 'asc'],
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, string>
     */
    private function configurationFiles(): array
    {
        return collect(glob(config_path('*.php')) ?: [])
            ->map(fn (string $path): string => str_replace(base_path().DIRECTORY_SEPARATOR, '', $path))
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{name: string, description: string|null}>
     */
    private function artisanCommands(): array
    {
        return collect(Artisan::all())
            ->map(fn (SymfonyCommand $command, string $name): array => [
                'name' => $name,
                'description' => $command->getDescription() ?: null,
            ])
            ->sortBy('name')
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function environment(): array
    {
        return [
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
            'url' => config('app.url'),
            'locale' => config('app.locale'),
            'fallback_locale' => config('app.fallback_locale'),
            'timezone' => config('app.timezone'),
            'app_env_file_present' => file_exists(base_path('.env')),
            'session_driver' => config('session.driver'),
            'cache_store' => config('cache.default'),
            'queue_connection' => config('queue.default'),
            'mail_mailer' => config('mail.default'),
            'filesystem_disk' => config('filesystems.default'),
        ];
    }
}

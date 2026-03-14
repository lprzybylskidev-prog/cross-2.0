<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tabuna\Breadcrumbs\Breadcrumbs;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [...parent::share($request), 'breadcrumbs' => $this->resolveBreadcrumbs($request)];
    }

    /**
     * @return array<int, array{title: string, url: string}>
     */
    private function resolveBreadcrumbs(Request $request): array
    {
        $routeName = $request->route()?->getName();

        if ($routeName === null) {
            return [];
        }

        if (Breadcrumbs::has($routeName)) {
            return Breadcrumbs::generate($routeName)
                ->map(
                    static fn(object $breadcrumb): array => [
                        'title' => (string) data_get($breadcrumb, 'title'),
                        'url' => (string) data_get($breadcrumb, 'url'),
                    ],
                )
                ->all();
        }

        return [
            [
                'title' => Str::of($routeName)
                    ->replace(['.', '-'], ' ')
                    ->title()
                    ->toString(),
                'url' => (string) $request->url(),
            ],
        ];
    }
}

# Cross Bootstrap Architecture

This document describes the current architecture baseline of the `cross` system.

## 1. Core Setup

- Laravel Jetstream installed with Inertia (Vue.js) and Teams support.
- Authentication routes are provided by Fortify/Jetstream.
- The main authenticated application module entrypoint is `/debtors` (`debtors.view`).
- The root route `/` redirects authenticated users with access to `/debtors`.

## 2. DDD Project Structure

The codebase includes a DDD-oriented structure under `src/`:

- `src/Domain`
- `src/Application`
- `src/Infrastructure`
- `src/Presentation`

Current examples:

- `Cross\Domain\Security\Permissions\SystemPermission` (enum for system-level permissions),
- `Cross\Application\Debtors\GetDebtorsPageData` (application use case),
- `Cross\Application\Admin\EnsureAdminUser` (admin bootstrap use case).

Laravel HTTP controllers delegate business behavior to the Application layer.

## 3. Authorization Model

Authorization is based on `spatie/laravel-permission`.

- Core permission: `admin` (full access).
- Route permission baseline:
    - `/debtors` is protected by `permission:debtors.view|admin`.
- Global middleware `EnsureRoutePermission` enforces route-based permission checks for authenticated users when a matching permission exists.

`Gate::before` grants global access for users holding `admin`.

## 4. Teams

Jetstream Teams represent organizational units/departments.

- New users operate in team-aware context.
- Admin bootstrap logic ensures the seeded admin has a personal team.

## 5. Breadcrumbs

Breadcrumb support is enabled with `tabuna/breadcrumbs`.

- Shared through Inertia middleware.
- `debtors.view` breadcrumb definition is registered in `routes/breadcrumbs.php`.
- Every new page should provide breadcrumb registration.

## 6. Seeders

Baseline seeders:

- `PermissionSeeder` creates core permissions (`admin`, `debtors.view`).
- `AdminUserSeeder` creates `Cross Admin` (`admin@cross.com`) and assigns `admin`.
- `DatabaseSeeder` executes both seeders.

## 7. Installed Packages

- `laravel/jetstream` (Teams + Vue/Inertia stack)
- `spatie/laravel-permission`
- `filament/filament`
- `owen-it/laravel-auditing`
- `barryvdh/laravel-debugbar` (dev)
- `tabuna/breadcrumbs`

## 8. Testing Baseline

- Backend tests run with Pest.
- Unit and Feature tests are configured to use the application test case and database refresh strategy.
- Custom tests cover:
    - admin seeding behavior,
    - debtors route permission behavior,
    - debtors application use case.

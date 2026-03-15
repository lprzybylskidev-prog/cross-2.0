# Filament Admin Panel

This document describes the current scope and rules of the Filament administration panel.

## 1. Access Model

- The panel is available under `/admin`.
- Access is restricted to authenticated users with the `admin` permission only.
- Authenticated users without the `admin` permission must receive `403 Forbidden`.

## 2. Coverage Rule

- Filament must expose support for every table that currently exists in the application database.
- When a new table is added, an existing table is changed, or business logic changes can affect administration workflows, the Filament panel must be updated in the same change.

## 3. Current Table Coverage

- Writable admin resources:
    - `users`
    - `teams`
    - `team_user`
    - `team_invitations`
    - `permissions`
    - `roles`
- Read-only operational or audit resources:
    - `audits`
    - `cache`
    - `cache_locks`
    - `failed_jobs`
    - `job_batches`
    - `jobs`
    - `migrations`
    - `model_has_permissions`
    - `model_has_roles`
    - `password_reset_tokens`
    - `personal_access_tokens`
    - `role_has_permissions`
    - `sessions`

## 4. Implementation Notes

- Filament resources live under `app/Filament/Resources`.
- Admin-only access is enforced through the Filament user access contract on `App\Models\User`.
- Filament resource pages provide built-in breadcrumbs and satisfy the project breadcrumb requirement for admin screens.
- Resources must be grouped in the Filament navigation by administrative area so the sidebar remains readable as the number of managed tables grows.
- The current navigation groups are `Users & Teams`, `Access Control`, `Operations`, and `Audit & Maintenance`.

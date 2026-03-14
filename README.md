# cross - development environment (DevContainer)

This repository contains a ready-to-use development environment for a **Laravel 12** application running in **DevContainer (VS Code) + Docker Compose**.

Core assumptions:

- custom container stack,
- Laravel backend + Vue/Vite/Tailwind frontend,
- built-in debugging, formatting, and testing tooling,
- ready-to-use PostgreSQL, Redis, and Mailpit services.

## About Cross 2.0

**Cross 2.0** is a system owned by **Cross Finance SA**, a debt collection company.

The platform is intended to support debt collection operations across the following stages:

- amicable (pre-court) stage,
- court stage,
- enforcement stage.

Its purpose is operational case handling for debt recovery workflows.

## Project Documentation

- Architecture and quality rules (authoritative): [docs/project-rules.md](docs/project-rules.md)
- Bootstrap architecture baseline: [docs/architecture-bootstrap.md](docs/architecture-bootstrap.md)
- Debtors module baseline: [docs/debtors-module.md](docs/debtors-module.md)

## Service architecture

1. `app`

- PHP-FPM 8.4 + Composer + Node.js 22 + npm + git + openssh-client,
- Laravel-ready PHP extensions (`pdo_pgsql`, `pgsql`, `xdebug`, `redis`, `intl`, `zip`, `opcache`),
- main development container for VS Code.

2. `nginx`

- reverse proxy for Laravel,
- standard entrypoint: `public/index.php`.

3. `pgsql`

- PostgreSQL 17,
- persistent data volume.

4. `redis`

- Redis 7.4 for cache, queues, and sessions.

5. `mailpit`

- local SMTP + web UI for email testing.

At container startup, the application entrypoint also prepares writable Laravel runtime directories such as `storage/*` and `bootstrap/cache` for the `www-data` process used by PHP-FPM.

## Key files

- `.devcontainer/devcontainer.json` - DevContainer configuration.
- `.devcontainer/docker-compose.yml` - service definitions.
- `.devcontainer/Dockerfile` - `app` image build.
- `docker/nginx/default.conf` - Nginx config.
- `docker/php/php.ini` - PHP settings.
- `docker/php/xdebug.ini` - Xdebug config.
- `docker/php/entrypoint.sh` - waits for dependent services.
- `scripts/format.sh` - project formatting.
- `scripts/test.sh` - backend/frontend tests + static analysis.
- `phpstan.neon.dist` - Larastan/PHPStan config.
- `vitest.config.ts` - frontend unit tests config.
- `playwright.config.ts` - E2E tests config.

## Startup

1. Open the project in VS Code.
2. Run `Dev Containers: Reopen in Container`.
3. Wait for build and services startup.

Additionally:

- `postCreateCommand` runs `npm install`,
- `postStartCommand` runs `setup-ssh`.

## Application config and dev credentials

Default application configuration (`.env`):

- `APP_NAME=cross`
- `APP_URL=http://localhost:8080`
- `DB_CONNECTION=pgsql`
- `DB_HOST=pgsql`
- `DB_PORT=5432`
- `DB_DATABASE=cross`
- `DB_USERNAME=cross`
- `DB_PASSWORD=cross`
- `REDIS_HOST=redis`
- `MAIL_HOST=mailpit`
- `MAIL_PORT=1025`

Seeder creates a development user:

- email: `cross@cross.com`
- password: `cross`

## Ports

- `8080` - application via Nginx,
- `5432` - PostgreSQL,
- `6379` - Redis,
- `8025` - Mailpit UI,
- `1025` - Mailpit SMTP,
- `9003` - Xdebug.

## Daily workflow

Formatting:

```bash
bash scripts/format.sh
```

Tests and analysis:

```bash
bash scripts/test.sh
```

The test script runs:

- backend tests via Pest,
- static analysis via PHPStan/Larastan,
- frontend unit tests via Vitest,
- optional Playwright E2E tests (`RUN_E2E_TESTS=1`).

## Debugging

- Xdebug runs on port `9003`.
- VS Code launch config: `.vscode/launch.json` -> `Listen for Xdebug (cross)`.

## SSH / Git

The container includes `git` and `openssh-client`, and `~/.ssh` is persisted in the `ssh-data` volume.

Example setup:

```bash
ssh-keygen -t ed25519 -C "cross@devcontainer"
ssh -T git@github.com
```

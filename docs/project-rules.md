# Cross Project Rules

This document is the primary and authoritative source of architecture and quality rules for the `cross` system.  
All contributors must follow these rules for every new feature and refactor.

## 1. Project Scope and Technology

`cross` is a large Laravel system with:

- API endpoints,
- a web administration panel,
- extensive business logic.

Technology stack:

- Backend: Laravel (latest), PHP with strict types, DDD architecture,
- Frontend: Vue.js, Tailwind CSS (utility-first), Vite,
- Authentication and organization model: Laravel Jetstream with Teams,
- Authorization: `spatie/laravel-permission`.

## 2. General Engineering Principles

- Code must be written for long-term maintainability.
- Creating technical debt is not allowed.
- Every feature must be designed before implementation.
- Implementations should be production-ready and not require immediate refactoring.
- Prefer clarity, explicitness, and consistency over shortcuts.

## 3. PHP Standards

The entire project must use:

```php
declare(strict_types=1);
```

Mandatory typing rules:

- all class properties must be typed,
- all method/function parameters must be typed,
- all method/function return values must be typed.

Forbidden:

- magic strings,
- magic numbers.

Required alternatives:

- Enums,
- Value Objects.

## 4. Architecture (DDD)

The system follows Domain-Driven Design with these core layers:

- Domain,
- Application,
- Infrastructure,
- Presentation.

Rules:

- Business logic must not be implemented in controllers.
- Controllers only orchestrate requests/responses and delegate use cases to the Application layer.
- Domain entities must not depend on Laravel/framework-specific classes.
- Domain rules must be explicit, testable, and isolated from delivery concerns.

## 5. Frontend Rules

Frontend implementation is limited to:

- Vue.js for UI logic and components,
- Tailwind CSS (utility-first) for styling.

Vue component rules:

- keep components small,
- keep components readable,
- design components for reuse.

API interaction rules:

- API logic must live in dedicated `services` or `composables`,
- avoid embedding API calls directly in view-heavy components whenever possible.

## 6. Permissions and Access Control

The project uses `spatie/laravel-permission`.

Rules:

- every system route must have a matching permission,
- permission names should follow a clear resource-action convention.

Example:

- `notes.view`
- `notes.create`
- `notes.update`
- `notes.delete`

## 7. Teams Model

Laravel Jetstream Teams represent company departments.

Rules:

- a Team corresponds to an organizational department,
- system data may be team-scoped when required by business rules.

## 8. Navigation

- Every system page must provide breadcrumbs.

## 9. Testing Strategy

The project must maintain high test coverage.

Rules:

- every business operation must have a unit test or an integration test,
- frontend code should also include automated tests.

Recommended test distribution:

- Domain/Application logic: unit and integration tests,
- API and workflow behavior: integration/feature tests,
- frontend behavior: component/unit tests (and E2E when needed).

## 10. Documentation Policy

- Every significant system element must be documented in the `docs` directory.
- Every new documentation file must be linked from `README.md`.
- Documentation must describe the current, factual state of the project only.
- Documentation must not include implementation history, removed elements, rejected approaches, prompt instructions, or explanations of what is not used.
- If a component or behavior no longer exists in the codebase, references to it must be removed from documentation instead of being described historically.

## 11. Compliance

These rules are mandatory for all contributors and all modules.  
If implementation constraints force an exception, the exception must be:

- documented,
- justified,
- approved before merge.

## 12. Pre-Commit and Pre-Push Workflow

- Before every `commit` and `push`, contributors must run `bash scripts/test.sh`.
- If tests, analysis, or checks fail, the contributor must fix the code and update documentation in `docs` when required before proceeding.
- After the project is in a valid state, contributors must run `bash scripts/format.sh`.
- The required order is: tests, fixes, documentation updates if needed, formatting, `commit`, `push`.

## 13. Framework Compatibility Rule

- Type strictness is mandatory, but framework contracts always take precedence.
- When extending Laravel or third-party framework classes, child method signatures and property declarations must remain fully compatible with parent contracts.
- If a framework constraint prevents adding stronger typing in a specific override, keep the compatible signature and document the reason in code review or implementation notes.

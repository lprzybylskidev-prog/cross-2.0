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
- Unused code, files, translations, assets, and legacy scaffolding must be removed as part of the current change instead of being left in the repository.
- Generated public assets (for example Filament assets published to `public/`) must remain generated artifacts: they must not be manually edited, prettified, or reformatted, and if they are committed they should stay in their published minified form.

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

UI/UX rules:

- the UI must use dedicated application layouts for authenticated application screens and authentication screens,
- application layouts must expose the project-level controls required by the current UI model, including locale switching, theme switching, and reusable foundations for future country-related UI extensions,
- every page and component must be fully responsive from the first implementation,
- the default visual theme is dark mode, with support for light and system themes,
- theme colors should follow the project palette direction currently based on Catppuccin-inspired dark Mocha and light Latte variants,
- theme tokens and component styling must be consistent across application pages, authentication pages, and transactional emails,
- visual design should resemble a business application, not a marketing landing page,
- native browser HTML validation must not be used; forms must rely on project-defined validation logic and messaging,
- frontend feedback must use a shared flash/notification module that supports backend and frontend events,
- flash and toast notifications must be displayed in the top-right area using the shared notification module,
- iconography should use `tabler.io` packages adopted by the project,
- country flag rendering must use a reusable system prepared for multi-country support.

Localization rules:

- the application must support Polish and English in parallel,
- the default locale is Polish,
- all translatable texts must use translation keys (for example `auth.login.submit`) instead of inline natural-language labels,
- backend validation messages, page labels, component copy, and transactional email content must follow the same translation-key strategy,
- validation attribute names must be localized and human-readable in every supported language, so user-facing validation messages must never expose raw field keys such as `password`, `current_password`, `locale`, or `theme`,
- backend and frontend translations must stay synchronized for all user-facing flows,
- every translation change introduced in one supported language must be updated in the other supported languages within the same change,
- locale preference must persist in cookies for guests and in the authenticated user profile for signed-in users.

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
- Authentication and account-access screens may intentionally omit breadcrumbs when they do not improve usability.
- The left application navigation must list system modules.
- The top application navigation must list links that belong to the currently opened module only.
- Peripheral screens such as user profile or account utilities must not be treated as application modules in the main navigation.

## 9. Testing Strategy

The project must maintain high test coverage.

Rules:

- every business operation must have a unit test or an integration test,
- frontend code should also include automated tests.
- new or materially changed shared frontend components, composables, and layout interactions must receive automated frontend tests within the same change; helper-only coverage is not sufficient when the behavior lives in UI components or shared presentation logic,
- shared mechanisms (for example middleware, localization plumbing, breadcrumb sharing, layout-level behavior, or permission infrastructure) must be tested at the shared layer rather than duplicated through module-specific tests,
- module-specific tests should focus on module behavior, while a single smoke test per module is acceptable only when it verifies module wiring and not shared infrastructure already covered elsewhere.
- changes explicitly requested as temporary, test-only, visual-only, or throwaway prototypes do not require dedicated tests if they are expected to be removed shortly and do not alter real business behavior.

Recommended test distribution:

- Domain/Application logic: unit and integration tests,
- API and workflow behavior: integration/feature tests,
- frontend behavior: component/unit tests (and E2E when needed).

## 10. AI Collaboration Rules

- AI agents must read `docs/project-rules.md` before generating or modifying code.
- `docs/project-rules.md` is the main and authoritative rule source for AI assistants working in this repository.
- Agent-specific instruction files should point back to `docs/project-rules.md` as the primary project rule document.

## 11. Documentation Policy

- Every significant system element must be documented in the `docs` directory.
- Every new documentation file must be linked from `README.md`.
- Documentation must describe the current, factual state of the project only.
- Documentation must not include implementation history, removed elements, rejected approaches, prompt instructions, or explanations of what is not used.
- If a component or behavior no longer exists in the codebase, references to it must be removed from documentation instead of being described historically.
- Changes explicitly marked by the user as temporary, test-only, or short-lived visual experiments do not require dedicated documentation files or README updates when they are intended for near-term removal.

## 12. Compliance

These rules are mandatory for all contributors and all modules.  
If implementation constraints force an exception, the exception must be:

- documented,
- justified,
- approved before merge.

## 13. Pre-Commit and Pre-Push Workflow

- Before every `commit` and `push`, contributors must run `bash scripts/test.sh`.
- If tests, analysis, or checks fail, the contributor must fix the code and update documentation in `docs` when required before proceeding.
- After the project is in a valid state, contributors must run `bash scripts/format.sh`.
- The required order is: tests, fixes, documentation updates if needed, formatting, `commit`, `push`.
- Commit messages must use a Conventional Commits style.
- Every commit must start with a type such as `feat:`, `fix:`, `refactor:`, `docs:`, `test:`, or `chore:`.
- Scoped variants such as `feat(scope): short description` or `fix(scope): short description` should be used when the scope makes the change clearer.
- Commit descriptions must be concise, lowercase, and written in English.
- Generic commit messages such as `update`, `changes`, `fix stuff`, or `work in progress` are not allowed.

## 14. Framework Compatibility Rule

- Type strictness is mandatory, but framework contracts always take precedence.
- When extending Laravel or third-party framework classes, child method signatures and property declarations must remain fully compatible with parent contracts.
- If a framework constraint prevents adding stronger typing in a specific override, keep the compatible signature and document the reason in code review or implementation notes.

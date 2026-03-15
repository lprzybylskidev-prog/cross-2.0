# DDD Layering And app/src Boundaries

This document defines the target layering model for the `cross` system and clarifies how `app/` and `src/` collaborate.

## 1. Intent

The repository uses Laravel as the runtime framework, but the application architecture must be expressed through DDD layers under `src/`:

- `Domain`
- `Application`
- `Infrastructure`
- `Presentation`

The `app/` directory remains only for framework bootstrap and for classes that Laravel or installed packages expect to live there.

## 2. Responsibility Split

### `app/`

`app/` may contain:

- Eloquent models,
- service providers,
- framework policies,
- middleware that is purely Laravel bootstrap glue,
- thin adapter classes required by Fortify, Jetstream, Filament, or similar packages,
- package-facing entrypoints that cannot be moved cleanly because the package contract is framework-owned.

`app/` must not become the home of application use cases or business rules.

### `src/Domain`

`Domain` contains:

- domain rules,
- value objects,
- enums,
- domain services,
- concepts that express invariants or business meaning without Laravel dependencies.

`Domain` must not depend on:

- Eloquent models,
- facades,
- HTTP classes,
- service container APIs,
- package-specific framework objects.

### `src/Application`

`Application` contains:

- use cases,
- orchestration of business flows,
- DTOs and command/query payloads,
- contracts (ports) required from infrastructure,
- module-level coordination between domain rules and external integrations.

`Application` may depend on `Domain`, but should not depend directly on:

- `App\Models\...`,
- facades,
- HTTP requests or responses,
- package-specific contract implementations,
- direct database access.

When persistence, authorization, hashing, transactions, mail, notifications, or package integration is needed, `Application` must call a port defined in `src/Application` and implemented in `src/Infrastructure`.

### `src/Infrastructure`

`Infrastructure` contains framework and package integrations such as:

- Eloquent-backed repositories and gateways,
- authorization adapters using Laravel policies or gates,
- permission management using Spatie,
- hashing, transactions, mail, notifications, and events,
- Jetstream and Fortify integration services,
- any adapter that translates application ports into Laravel/package-specific operations.

Infrastructure may depend on Laravel and package APIs, but it must not absorb product-specific delivery code that belongs in `Presentation`.

### `src/Presentation`

`Presentation` contains application-facing delivery code such as:

- HTTP controllers,
- form requests,
- presenters,
- response/view model mappers,
- other input/output adapters that shape traffic into application use cases.

Presentation may depend on `Application` and selected framework primitives required for delivery, but it must not embed business rules.

## 3. Practical Rule For `app/Actions`

`app/Actions` exists because Fortify and Jetstream require concrete classes that implement their contracts.

Allowed content in `app/Actions`:

- package contract implementation,
- request-oriented validation that is tightly coupled to the package form shape,
- delegation to one application use case.

Forbidden content in `app/Actions`:

- business decisions,
- reusable orchestration,
- direct coordination of multiple infrastructure concerns when an application use case should own that flow,
- duplicated logic also used elsewhere.

If an action grows beyond thin adaptation, the real logic must be extracted to `src/Application` and `src/Infrastructure`.

## 4. Communication Rules Between Layers

- `Presentation` calls `Application`.
- `Application` calls `Domain` and application ports.
- `Infrastructure` implements application ports.
- `Domain` must not know `Application`, `Infrastructure`, or `Presentation`.

Cross-module communication must happen through:

- DTOs,
- value objects,
- explicit application contracts,
- well-defined public use cases.

Direct access to another module's internal infrastructure or private implementation classes is not allowed.

## 5. Migration Rules For Existing Laravel Logic

When logic is currently inside a framework class, refactors should follow this order:

1. Identify the actual use case or business rule.
2. Move orchestration into `src/Application`.
3. Move invariant or naming/decision rules into `src/Domain` when they carry business meaning.
4. Leave Laravel, Eloquent, Gate, DB, Mail, Hash, Jetstream, and Fortify details in `src/Infrastructure`.
5. Keep `app/` as the thinnest possible compatibility layer.

If a framework dependency cannot be removed immediately, the remaining coupling must be:

- minimized,
- isolated behind one adapter or port,
- explained in code comments or nearby documentation when the boundary is not obvious.

## 6. Documentation Expectations

Each significant module should document:

- its use cases,
- its layer boundaries,
- its public integration points,
- the infrastructure adapters it relies on,
- any approved temporary deviation from the target DDD model.

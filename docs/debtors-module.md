# Debtors Module

This document describes the current baseline of the `Debtors` module.

## 1. Entry Point

- The main authenticated application entrypoint is `/debtors`.
- The root route `/` redirects to `/debtors`.

## 2. Permission Model

- The module entry route uses the `debtors.view` permission.
- Users with the `admin` permission also have access through the global access model.

## 3. Navigation Model

- The left application navigation lists system modules.
- `Debtors` is currently the primary module exposed in the application navigation.
- The top navigation is reserved for links belonging to the currently opened module.
- The current `Debtors` module does not expose additional top-navigation links yet.

## 4. Current UI State

- The module currently exposes a placeholder page only.
- The layout, route, permission, and breadcrumbs are already prepared for further implementation.

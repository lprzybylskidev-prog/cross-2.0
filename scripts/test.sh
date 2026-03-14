#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

echo "[test] Starting test workflow..."

if [[ ! -f artisan ]]; then
  echo "[test] ERROR: Laravel project not detected (missing artisan)."
  exit 1
fi

if [[ ! -d vendor ]]; then
  echo "[test] vendor directory missing. Running composer install first..."
  composer install
fi

if [[ ! -d node_modules ]]; then
  echo "[test] node_modules missing. Running npm install first..."
  npm_config_cache=/tmp/.npm-cache npm install
fi

echo "[test] Running backend tests (Pest)..."
./vendor/bin/pest --colors=always

echo "[test] Running static analysis (PHPStan/Larastan)..."
./vendor/bin/phpstan analyse --memory-limit=1G

echo "[test] Running frontend unit tests (Vitest)..."
npm run test:unit

if [[ "${RUN_E2E_TESTS:-0}" == "1" ]]; then
  echo "[test] RUN_E2E_TESTS=1 -> running Playwright tests..."
  npm run test:e2e
else
  echo "[test] Skipping Playwright tests. Set RUN_E2E_TESTS=1 to include E2E."
fi

echo "[test] Workflow finished."

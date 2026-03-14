#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

echo "[format] Starting project formatting..."

if [[ ! -f package.json ]]; then
  echo "[format] ERROR: package.json not found."
  echo "[format] Run this script from the project root mounted in the app container."
  exit 1
fi

if [[ ! -d node_modules ]]; then
  echo "[format] node_modules not found; installing formatter dependencies..."
  npm install
fi

echo "[format] Running Prettier..."
npx prettier --write --ignore-unknown \
  app \
  bootstrap \
  config \
  database \
  docs \
  lang \
  resources \
  routes \
  scripts \
  src \
  tests \
  .env.example \
  README.md \
  composer.json \
  package.json \
  vite.config.js \
  vitest.config.ts \
  playwright.config.ts \
  phpstan.neon.dist \
  .prettierrc.json \
  .prettierignore

echo "[format] Completed successfully."

#!/usr/bin/env bash
set -euo pipefail

prepare_laravel_runtime_permissions() {
  local path

  for path in \
    /workspace/storage \
    /workspace/storage/app \
    /workspace/storage/framework \
    /workspace/storage/framework/cache \
    /workspace/storage/framework/sessions \
    /workspace/storage/framework/testing \
    /workspace/storage/framework/views \
    /workspace/storage/logs \
    /workspace/bootstrap/cache
  do
    mkdir -p "${path}"
  done

  chgrp -R www-data /workspace/storage /workspace/bootstrap/cache
  chmod -R g+rwX /workspace/storage /workspace/bootstrap/cache
  find /workspace/storage /workspace/bootstrap/cache -type d -exec chmod g+s {} +
}

wait_for_service() {
  local host="$1"
  local port="$2"
  local name="$3"

  echo "[entrypoint] Waiting for ${name} at ${host}:${port}..."
  for _ in {1..60}; do
    if nc -z "${host}" "${port}" >/dev/null 2>&1; then
      echo "[entrypoint] ${name} is reachable."
      return 0
    fi
    sleep 1
  done

  echo "[entrypoint] ERROR: ${name} (${host}:${port}) is not reachable after 60s." >&2
  return 1
}

wait_for_service "pgsql" "5432" "PostgreSQL"
wait_for_service "redis" "6379" "Redis"
wait_for_service "mailpit" "1025" "Mailpit SMTP"

mkdir -p /home/vscode/.ssh
chown -R vscode:vscode /home/vscode/.ssh
chmod 700 /home/vscode/.ssh

prepare_laravel_runtime_permissions

exec "$@"

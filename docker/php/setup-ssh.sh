#!/usr/bin/env bash
set -euo pipefail

SSH_DIR="/home/vscode/.ssh"
KNOWN_HOSTS="${SSH_DIR}/known_hosts"

mkdir -p "${SSH_DIR}"
chmod 700 "${SSH_DIR}"

if [[ ! -f "${KNOWN_HOSTS}" ]]; then
  touch "${KNOWN_HOSTS}"
  chmod 644 "${KNOWN_HOSTS}"
fi

for host in github.com gitlab.com bitbucket.org; do
  if ! grep -q "^${host} " "${KNOWN_HOSTS}" 2>/dev/null; then
    ssh-keyscan -H "${host}" >> "${KNOWN_HOSTS}" 2>/dev/null || true
  fi
done

echo "[setup-ssh] SSH directory prepared at ${SSH_DIR}."

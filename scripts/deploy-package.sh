#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RELEASE_DIR="$ROOT_DIR/.release"
RELEASE_ZIP="$ROOT_DIR/release.zip"

if command -v npm.cmd >/dev/null 2>&1; then
  NPM_BIN="npm.cmd"
else
  NPM_BIN="npm"
fi

echo "[1/4] Build frontend"
(
  cd "$ROOT_DIR/frontend"
  "$NPM_BIN" run build
)

echo "[2/4] Install production Composer dependencies"
if command -v composer >/dev/null 2>&1; then
  (
    cd "$ROOT_DIR/api"
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
  )
else
  echo "Composer not found, skip this step."
fi

echo "[3/4] Prepare release payload"
rm -rf "$RELEASE_DIR" "$RELEASE_ZIP"
mkdir -p "$RELEASE_DIR"

cp -r "$ROOT_DIR/api" "$RELEASE_DIR/api"
cp -r "$ROOT_DIR/sql" "$RELEASE_DIR/sql"
cp -r "$ROOT_DIR/assets" "$RELEASE_DIR/assets"
cp "$ROOT_DIR/.htaccess" "$RELEASE_DIR/.htaccess"
cp "$ROOT_DIR/index.php" "$RELEASE_DIR/index.php"
cp "$ROOT_DIR/favicon.svg" "$RELEASE_DIR/favicon.svg"
cp "$ROOT_DIR/README.md" "$RELEASE_DIR/README.md"

rm -f "$RELEASE_DIR/api/.env"

echo "[4/4] Compress release"
if command -v zip >/dev/null 2>&1; then
  (
    cd "$RELEASE_DIR"
    zip -r "$RELEASE_ZIP" . >/dev/null
  )
  echo "Release zip: $RELEASE_ZIP"
else
  echo "zip not available. Upload folder: $RELEASE_DIR"
fi

echo "Done."

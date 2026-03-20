#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RELEASE_DIR="$ROOT_DIR/.release"
RELEASE_ZIP="$ROOT_DIR/release.zip"
STATE_DIR="$ROOT_DIR/.deploy-state"
LOCK_HASH_FILE="$STATE_DIR/composer.lock.sha256"

VENDOR_MODE="smart"

for arg in "$@"; do
  case "$arg" in
    --with-vendor)
      VENDOR_MODE="with"
      ;;
    --without-vendor)
      VENDOR_MODE="without"
      ;;
    *)
      echo "Unknown option: $arg"
      echo "Usage: bash scripts/deploy-package.sh [--with-vendor|--without-vendor]"
      exit 1
      ;;
  esac
done

hash_file() {
  php -r 'echo hash_file("sha256", $argv[1]);' "$1"
}

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

CURRENT_LOCK_HASH="$(hash_file "$ROOT_DIR/api/composer.lock")"
INCLUDE_VENDOR="true"

if [[ "$VENDOR_MODE" == "without" ]]; then
  INCLUDE_VENDOR="false"
elif [[ "$VENDOR_MODE" == "smart" ]] && [[ -f "$LOCK_HASH_FILE" ]]; then
  LAST_LOCK_HASH="$(cat "$LOCK_HASH_FILE")"
  if [[ "$LAST_LOCK_HASH" == "$CURRENT_LOCK_HASH" ]]; then
    INCLUDE_VENDOR="false"
  fi
fi

echo "[3/4] Prepare release payload"
rm -rf "$RELEASE_DIR" "$RELEASE_ZIP"
mkdir -p "$RELEASE_DIR"

cp -r "$ROOT_DIR/api" "$RELEASE_DIR/api"
cp -r "$ROOT_DIR/sql" "$RELEASE_DIR/sql"
cp "$ROOT_DIR/.htaccess" "$RELEASE_DIR/.htaccess"
cp "$ROOT_DIR/index.php" "$RELEASE_DIR/index.php"
cp "$ROOT_DIR/README.md" "$RELEASE_DIR/README.md"

rm -f "$RELEASE_DIR/api/.env"

if [[ "$INCLUDE_VENDOR" != "true" ]]; then
  rm -rf "$RELEASE_DIR/api/vendor"
  echo "Vendor omitted from release (composer.lock unchanged)."
else
  mkdir -p "$STATE_DIR"
  printf '%s' "$CURRENT_LOCK_HASH" > "$LOCK_HASH_FILE"
  echo "Vendor included in release."
fi

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

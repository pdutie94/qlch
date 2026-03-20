<?php

declare(strict_types=1);

$projectRoot = __DIR__;
$apiPublicDir = $projectRoot . '/api/public';
$requestPath = rawurldecode((string) (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'));

function detectMimeType(string $filePath): string
{
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    $map = [
        'js' => 'application/javascript; charset=UTF-8',
        'mjs' => 'application/javascript; charset=UTF-8',
        'css' => 'text/css; charset=UTF-8',
        'html' => 'text/html; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'map' => 'application/json; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
    ];

    if (isset($map[$extension])) {
        return $map[$extension];
    }

    $detected = mime_content_type($filePath);

    return $detected !== false ? $detected : 'application/octet-stream';
}

function findLatestBundle(string $assetsDir, string $extension): ?string
{
    $candidates = glob($assetsDir . '/index-*.' . $extension);

    if ($candidates === false || $candidates === []) {
        return null;
    }

    usort(
        $candidates,
        static fn (string $a, string $b): int => filemtime($b) <=> filemtime($a)
    );

    return $candidates[0] ?? null;
}

// Send API and health traffic to Slim.
if ($requestPath === '/health' || str_starts_with($requestPath, '/api/')) {
    require $apiPublicDir . '/index.php';
    exit;
}

// Serve built frontend assets from api/public.
if ($requestPath !== '/' && $requestPath !== '') {
    $assetPath = realpath($apiPublicDir . $requestPath);
    $publicRealPath = realpath($apiPublicDir);

    if (
        $assetPath !== false
        && $publicRealPath !== false
        && str_starts_with(str_replace('\\', '/', $assetPath), str_replace('\\', '/', $publicRealPath))
        && is_file($assetPath)
    ) {
        header('Content-Type: ' . detectMimeType($assetPath));
        header('Content-Length: ' . (string) filesize($assetPath));
        readfile($assetPath);
        exit;
    }

    // Fallback for stale browser cache requesting old hashed bundle names.
    if (preg_match('#^/assets/index-[^/]+\.(js|css)$#', $requestPath, $matches) === 1) {
        $latestBundle = findLatestBundle($apiPublicDir . '/assets', $matches[1]);

        if ($latestBundle !== null && is_file($latestBundle)) {
            header('Content-Type: ' . detectMimeType($latestBundle));
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('Expires: 0');
            header('Content-Length: ' . (string) filesize($latestBundle));
            readfile($latestBundle);
            exit;
        }
    }
}

// SPA fallback.
$indexFile = $apiPublicDir . '/index.html';
if (is_file($indexFile)) {
    header('Content-Type: text/html; charset=UTF-8');
    readfile($indexFile);
    exit;
}

http_response_code(503);
header('Content-Type: text/plain; charset=UTF-8');
echo 'Frontend bundle not found. Run: cd frontend && npm.cmd run build';

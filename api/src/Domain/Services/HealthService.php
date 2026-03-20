<?php

declare(strict_types=1);

namespace App\Domain\Services;

use PDO;
use Throwable;

final class HealthService
{
    public function __construct(
        private readonly array $databaseConfig,
        private readonly MigrationService $migrationService,
    ) {
    }

    public function check(): array
    {
        return [
            'status' => 'ok',
            'timestamp' => gmdate(DATE_ATOM),
            'checks' => [
                'php' => [
                    'ok' => true,
                    'version' => PHP_VERSION,
                ],
                'database' => $this->databaseStatus(),
                'disk' => [
                    'ok' => disk_free_space(dirname(__DIR__, 3)) !== false,
                    'free_bytes' => disk_free_space(dirname(__DIR__, 3)) ?: 0,
                ],
                'migration' => [
                    'ok' => $this->migrationService->pendingVersions() === [],
                    'current_version' => $this->migrationService->currentVersion(),
                    'pending_versions' => $this->migrationService->pendingVersions(),
                ],
            ],
        ];
    }

    private function databaseStatus(): array
    {
        if (($this->databaseConfig['database'] ?? '') === '') {
            return [
                'ok' => false,
                'message' => 'Database is not configured.',
            ];
        }

        try {
            $dsn = sprintf(
                '%s:host=%s;port=%d;dbname=%s;charset=%s',
                $this->databaseConfig['driver'],
                $this->databaseConfig['host'],
                $this->databaseConfig['port'],
                $this->databaseConfig['database'],
                $this->databaseConfig['charset']
            );

            new PDO($dsn, $this->databaseConfig['username'], $this->databaseConfig['password']);

            return [
                'ok' => true,
                'message' => 'Database connection available.',
            ];
        } catch (Throwable $exception) {
            return [
                'ok' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}

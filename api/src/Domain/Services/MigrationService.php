<?php

declare(strict_types=1);

namespace App\Domain\Services;

final class MigrationService
{
    public function __construct(
        private readonly string $sqlPath,
        private readonly string $currentVersion,
    ) {
    }

    public function currentVersion(): string
    {
        return $this->currentVersion;
    }

    public function availableVersions(): array
    {
        $files = glob($this->sqlPath . '/*.sql') ?: [];
        $versions = [];

        foreach ($files as $file) {
            $filename = basename($file, '.sql');
            if (preg_match('/^\d+\.\d+\.\d+$/', $filename) === 1) {
                $versions[] = $filename;
            }
        }

        usort($versions, 'version_compare');

        return $versions;
    }

    public function pendingVersions(): array
    {
        return array_values(array_filter(
            $this->availableVersions(),
            fn (string $version): bool => version_compare($version, $this->currentVersion, '>')
        ));
    }
}

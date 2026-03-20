<?php

declare(strict_types=1);

namespace App\Domain\Services;

final class MetricsService
{
    public function measure(string $label, callable $callback): array
    {
        $startedAt = microtime(true);
        $payload = $callback();
        $durationMs = round((microtime(true) - $startedAt) * 1000, 2);

        return [
            'metric' => $label,
            'duration_ms' => $durationMs,
            'data' => $payload,
        ];
    }
}

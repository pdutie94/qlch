<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Responders\JsonResponder;
use App\Domain\Services\MetricsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DashboardSummaryAction
{
    public function __construct(
        private readonly JsonResponder $responder,
        private readonly MetricsService $metricsService,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $measurement = $this->metricsService->measure('dashboard.summary', static function (): array {
            return [
                'cards' => [
                    ['key' => 'revenue', 'label' => 'Revenue', 'value' => 18650000, 'delta' => '+12.4%'],
                    ['key' => 'profit', 'label' => 'Profit', 'value' => 4720000, 'delta' => '+8.1%'],
                    ['key' => 'collected', 'label' => 'Collected', 'value' => 14400000, 'delta' => '+5.2%'],
                    ['key' => 'debt', 'label' => 'Debt', 'value' => 2980000, 'delta' => '-3.4%'],
                ],
                'alerts' => [
                    ['sku' => 'SP-001', 'name' => 'Ca phe sua chai', 'stock' => 4],
                    ['sku' => 'SP-024', 'name' => 'Tra dao lon', 'stock' => 7],
                    ['sku' => 'SP-086', 'name' => 'Sua chua uong', 'stock' => 5],
                ],
            ];
        });

        return $this->responder->respond($response, $measurement);
    }
}

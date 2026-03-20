<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Responders\JsonResponder;
use App\Domain\Services\HealthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HealthAction
{
    public function __construct(
        private readonly JsonResponder $responder,
        private readonly HealthService $healthService,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->responder->respond($response, $this->healthService->check());
    }
}

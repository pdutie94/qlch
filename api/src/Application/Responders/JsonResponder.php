<?php

declare(strict_types=1);

namespace App\Application\Responders;

use Psr\Http\Message\ResponseInterface;

final class JsonResponder
{
    public function respond(ResponseInterface $response, array $payload, int $status = 200): ResponseInterface
    {
        $response->getBody()->write((string) json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}

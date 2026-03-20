<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Responders\JsonResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ModuleManifestAction
{
    public function __construct(private readonly JsonResponder $responder)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->responder->respond($response, [
            'modules' => [
                ['key' => 'auth', 'label' => 'Auth', 'status' => 'planned'],
                ['key' => 'dashboard', 'label' => 'Dashboard', 'status' => 'in-progress'],
                ['key' => 'pos', 'label' => 'POS', 'status' => 'in-progress'],
                ['key' => 'orders', 'label' => 'Orders', 'status' => 'planned'],
                ['key' => 'products', 'label' => 'Products', 'status' => 'planned'],
                ['key' => 'customers', 'label' => 'Customers', 'status' => 'planned'],
                ['key' => 'purchases', 'label' => 'Purchases', 'status' => 'planned'],
                ['key' => 'metadata', 'label' => 'Metadata', 'status' => 'planned'],
                ['key' => 'reports', 'label' => 'Reports', 'status' => 'planned'],
                ['key' => 'users', 'label' => 'Users', 'status' => 'planned'],
                ['key' => 'utilities', 'label' => 'Utilities', 'status' => 'in-progress'],
            ],
        ]);
    }
}

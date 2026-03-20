<?php

declare(strict_types=1);

use App\Application\Responders\JsonResponder;
use App\Domain\Services\HealthService;
use App\Domain\Services\MetricsService;
use App\Domain\Services\MigrationService;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;

$config = require dirname(__DIR__) . '/config/app.php';

$capsule = new Capsule();
$capsule->addConnection($config['db']);
$capsule->setAsGlobal();

$responder = new JsonResponder();
$migrationService = new MigrationService(
    $config['migration']['path'],
    $config['migration']['current_version']
);
$healthService = new HealthService($config['db'], $migrationService);
$metricsService = new MetricsService();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($config['app']['debug'], true, true);

$app->get('/', static function (ServerRequestInterface $request, ResponseInterface $response) use ($responder): ResponseInterface {
    return $responder->respond($response, [
        'name' => 'QLCH API',
        'status' => 'ready',
        'version' => '0.1.0',
    ]);
});

$registerRoutes = require dirname(__DIR__) . '/config/routes.php';
$registerRoutes($app, [
    'responder' => $responder,
    'migration' => $migrationService,
    'health' => $healthService,
    'metrics' => $metricsService,
]);

$app->run();

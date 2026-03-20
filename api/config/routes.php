<?php

declare(strict_types=1);

use App\Application\Actions\DashboardSummaryAction;
use App\Application\Actions\HealthAction;
use App\Application\Actions\ModuleManifestAction;
use Slim\App;

return static function (App $app, array $services): void {
    $app->get('/health', new HealthAction($services['responder'], $services['health']));

    $app->group('/api/v1', static function ($group) use ($services): void {
        $group->get('/modules', new ModuleManifestAction($services['responder']));
        $group->get('/dashboard/summary', new DashboardSummaryAction($services['responder'], $services['metrics']));
    });
};

<?php

namespace ApperPH\SamplePHPApplication;

use ApperPH\SamplePHPApplication\Http\Controllers;
use Bramus\Router\Router;

$router = new Router();

$router->get('/', Controllers\MainController::class . '@index');
$router->get('/ul/health', Controllers\MainController::class . '@healthcheck');

$router->post(
    '/ul/health/simulate-success',
    Controllers\MainController::class . '@simulateSuccess'
);

$router->post(
    '/ul/health/simulate-failed',
    Controllers\MainController::class . '@simulateFailed'
);

$router->run();

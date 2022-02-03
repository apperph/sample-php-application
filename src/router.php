<?php

namespace ApperPH\SamplePHPApplication;

use ApperPH\SamplePHPApplication\Http\Controllers;
use Bramus\Router\Router;

$router = new Router();

$router->get('/', Controllers\MainController::class . '@index');
$router->get('/ul/health', Controllers\MainController::class . '@healthcheck');

$router->run();

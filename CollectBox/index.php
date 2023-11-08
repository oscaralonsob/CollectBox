<?php

use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestHandler;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));

(require_once __DIR__ . "/src/Infrastructure/Routes.php")($app);

$app->run();
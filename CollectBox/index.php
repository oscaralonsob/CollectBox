<?php

use Slim\Handlers\Strategies\RequestHandler;

require __DIR__ . '/vendor/autoload.php';
$dependencies = require_once __DIR__ . "/config/Dependencies.php";
$routes = require_once __DIR__ . "/config/Routes.php";

$builder = new DI\ContainerBuilder();
$dependencies($builder);
$container = $builder->build();

$app = \DI\Bridge\Slim\Bridge::create($container);
$app->addBodyParsingMiddleware();
$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));
$routes($app);
$app->run();
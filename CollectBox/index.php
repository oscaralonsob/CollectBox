<?php

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use Slim\Handlers\Strategies\RequestHandler;

require __DIR__ . '/vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([CollectibleRepository::class => \DI\autowire(CollectibleInMemoryRepository::class)]); //TODO: migrate this to other fiile like routes
$container = $builder->build();

$app = \DI\Bridge\Slim\Bridge::create($container);

$app->addBodyParsingMiddleware();
$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));

(require_once __DIR__ . "/src/Routes.php")($app);

$app->run();
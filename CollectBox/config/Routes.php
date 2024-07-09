<?php

declare(strict_types=1);

use Slim\App;
use App\Collectible\Infrastructure\UI\Handler\GetCollectiblesHandler;
use App\Collectible\Infrastructure\UI\Handler\GetCollectibleHandler;
use App\Home\Infrastructure\UI\Handler\HomeHandler;

return static function (App $app) {
  $app->get('/', HomeHandler::class);
  // Collectibles
  $app->get('/collectibles', GetCollectiblesHandler::class);
  $app->get('/collectibles/{id}', GetCollectibleHandler::class);
};
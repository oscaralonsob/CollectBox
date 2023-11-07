<?php

declare(strict_types=1);

use Slim\App;
use App\Infrastructure\UI\Collectible\GetCollectiblesHandler;
use App\Infrastructure\UI\Collectible\GetCollectibleHandler;

return static function (App $app) {
  // Get all collectibles
  $app->get('/collectibles', GetCollectiblesHandler::class);
  $app->get('/collectible/{id}', GetCollectibleHandler::class);
};
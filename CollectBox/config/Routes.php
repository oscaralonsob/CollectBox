<?php

declare(strict_types=1);

use Slim\App;
use App\Collectible\Infrastructure\UI\DeleteCollectibleHandler;
use App\Collectible\Infrastructure\UI\GetCollectiblesHandler;
use App\Collectible\Infrastructure\UI\GetCollectibleHandler;
use App\Collectible\Infrastructure\UI\PostCollectibleHandler;
use App\Collectible\Infrastructure\UI\PutCollectibleHandler;
use App\Home\Infrastructure\UI\HomeHandler;

return static function (App $app) {
  $app->get('/', HomeHandler::class);
  // Collectibles
  $app->get('/collectibles', GetCollectiblesHandler::class);
  $app->get('/collectible/{id}', GetCollectibleHandler::class);
  $app->post('/collectible', PostCollectibleHandler::class);
  $app->put('/collectible/{id}', PutCollectibleHandler::class);
  $app->delete('/collectible/{id}', DeleteCollectibleHandler::class);
};
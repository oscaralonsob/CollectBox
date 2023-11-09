<?php

declare(strict_types=1);

use App\Infrastructure\UI\Collectible\DeleteCollectibleHandler;
use Slim\App;
use App\Infrastructure\UI\Collectible\GetCollectiblesHandler;
use App\Infrastructure\UI\Collectible\GetCollectibleHandler;
use App\Infrastructure\UI\Collectible\PostCollectibleHandler;
use App\Infrastructure\UI\Collectible\PutCollectibleHandler;
use App\Infrastructure\UI\Home\HomeHandler;

return static function (App $app) {
  $app->get('/', HomeHandler::class);
  // Collectibles
  $app->get('/collectibles', GetCollectiblesHandler::class);
  $app->get('/collectible/{id}', GetCollectibleHandler::class);
  $app->post('/collectible', PostCollectibleHandler::class);
  $app->put('/collectible/{id}', PutCollectibleHandler::class);
  $app->delete('/collectible/{id}', DeleteCollectibleHandler::class);
};
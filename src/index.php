<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
];

// Get all collectibles
$app->get('/', function (Request $request, Response $response) use ($collectibles) {
  $response->getBody()->write("Hello");
  return $response;
});

// Get all collectibles
$app->get('/collectibles', function (Request $request, Response $response) use ($collectibles) {
  $response->getBody()->write(json_encode($collectibles));
  return $response;
});

// Get a specific collectible
$app->get('/collectibles/{id}', function (Request $request, Response $response, array $args) use ($collectibles) {
  $id = $args['id'];
  if (isset($collectibles[$id])) {
    $response->getBody()->write(json_encode($collectibles[$id]));  
  } else {
    $response->getBody()->write(json_encode(["error" => "Collectible not found"], 404));
  }
  return $response;
});

// Add a new collectible
$app->post('/collectibles', function (Request $request, Response $response) use ($collectibles) {
  $data = $request->getParsedBody();
  $newCollectibleId = max(array_keys($collectibles)) + 1;
  $collectibles[$newCollectibleId] = [
    "id" => $newCollectibleId,
    "name" => $data['name'],
    "rarity" => $data['rarity']
  ];
  $response->getBody()->write(json_encode(["message" => "Collectible added successfully"], 201));
  return $response;
});

// Update an existing collectible
$app->put('/collectibles/{id}', function (Request $request, Response $response, array $args) use ($collectibles) {
  $id = $args['id'];
  if (isset($collectibles[$id])) {
    $data = $request->getParsedBody();
    $collectibles[$id]['name'] = $data['name'];
    $collectibles[$id]['rarity'] = $data['rarity'];
    $response->getBody()->write(json_encode(["message" => "Collectible updated successfully"]));
  } else {
    $response->getBody()->write(json_encode(["error" => "Collectible not found"], 404));
  }
  return $response;
});

// Delete a collectible
$app->delete('/collectibles/{id}', function (Request $request, Response $response, array $args) use ($collectibles) {
  $id = $args['id'];
  if (isset($collectibles[$id])) {
    unset($collectibles[$id]);
    $response->getBody()->write(json_encode(["message" => "Collectible deleted successfully"]));
  } else {
    $response->getBody()->write(json_encode(["error" => "Collectible not found"], 404));
  }
  return $response;
});

$app->run();
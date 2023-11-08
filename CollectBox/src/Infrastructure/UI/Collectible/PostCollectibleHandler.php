<?php

namespace App\Infrastructure\UI\Collectible;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class PostCollectibleHandler implements RequestHandlerInterface
{
  private $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $name = $request->getParsedBody()['name'];
    $rarity = $request->getParsedBody()['rarity'];
    if (empty($name) || empty($rarity)) {
      $response->getBody()->write(json_encode(["error" => "Name or rarity missing"], 400));
    }else {
      $newCollectibleId = max(array_keys($this->collectibles)) + 1;
      $collectible = [
        "id" => $newCollectibleId,
        "name" => $name,
        "rarity" => $rarity
      ];
      $this->collectibles[$newCollectibleId] = $collectible;
      $response->getBody()->write(json_encode($collectible, 201));
    }
    
    return $response;
  }
}
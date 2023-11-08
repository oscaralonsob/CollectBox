<?php

namespace App\Infrastructure\UI\Collectible;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class PutCollectibleHandler implements RequestHandlerInterface
{
  private $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = $request->getAttribute("id");
    $name = $request->getParsedBody()["name"];
    $rarity = $request->getParsedBody()["rarity"];

    if (isset($this->collectibles[$id])) {
      $this->collectibles[$id] = [
        "id" => $id,
        "name" => $name ?? $this->collectibles[$id]["name"],
        "rarity" => $rarity ?? $this->collectibles[$id]["rarity"],
      ];
      $response->getBody()->write(json_encode($this->collectibles[$id]));  
    } else {
      $response->getBody()->write(json_encode(["error" => "Collectible not found"], 404));
    }
    
    return $response;
  }
}
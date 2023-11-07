<?php

namespace App\Infrastructure\UI\Collectible;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class GetCollectiblesHandler implements RequestHandlerInterface
{
  private $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $response->getBody()->write(json_encode($this->collectibles));
    return $response;
  }
}
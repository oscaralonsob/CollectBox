<?php

namespace App\Infrastructure\UI\Collectible;

use App\Application\Collectible\GetCollectiblesQuery;
use App\Application\Collectible\GetCollectiblesQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class GetCollectiblesHandler implements RequestHandlerInterface
{
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $query = new GetCollectiblesQuery();
    $queryHandler = new GetCollectiblesQueryHandler();

    $result = $queryHandler->execute($query);

    $response = new Response(200);
    $response->getBody()->write(json_encode($result));
    return $response;
  }
}
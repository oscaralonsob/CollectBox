<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\GetCollectiblesQuery;
use App\Collectible\Application\GetCollectiblesQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class GetCollectiblesHandler implements RequestHandlerInterface
{
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $query = GetCollectiblesQuery::create();
    $queryHandler = new GetCollectiblesQueryHandler();

    $result = $queryHandler->execute($query);

    $response = new Response(200);
    $response->getBody()->write(json_encode($result));
    return $response;
  }
}
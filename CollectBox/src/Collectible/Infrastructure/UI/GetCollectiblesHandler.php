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
  public function __construct(private GetCollectiblesQueryHandler $getCollectiblesQueryHandler)
  {
  }
  
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $query = GetCollectiblesQuery::create();

    $result = $this->getCollectiblesQueryHandler->execute($query);
    $array = [];
    foreach ($result as $collectible) {
      $array[] = $collectible->toArray(); //TODO: Collection
    }

    $response = new Response(200);
    $response->getBody()->write(json_encode($array));

    return $response;
  }
}
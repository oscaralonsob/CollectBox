<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI\Handler;

use App\Collectible\Application\SearchCollectiblesQuery;
use App\Collectible\Application\SearchCollectiblesQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class GetCollectiblesHandler implements RequestHandlerInterface
{
  public function __construct(private SearchCollectiblesQueryHandler $searchCollectiblesQueryHandler)
  {
  }
  
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $query = SearchCollectiblesQuery::create();

    $result = $this->searchCollectiblesQueryHandler->execute($query);
    $array = [];
    foreach ($result as $collectible) {
      $array[] = $collectible->toArray();
    }

    $response = new Response(200);
    $response->getBody()->write(json_encode($array));

    return $response;
  }
}
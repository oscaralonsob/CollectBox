<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI\Handler;

use App\Collectible\Application\FindCollectibleByIdQuery;
use App\Collectible\Application\FindCollectibleByIdQueryHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class GetCollectibleHandler implements RequestHandlerInterface
{
  public function __construct(private FindCollectibleByIdQueryHandler $findCollectibleByIdQueryHandler)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = $request->getAttribute('id');

    $query = FindCollectibleByIdQuery::create($id);
    try {
      $result = $this->findCollectibleByIdQueryHandler->execute($query);

      $response->getBody()->write(json_encode($result->toArray()));  
    } catch (CollectibleNotFoundException $e) {
      $response->getBody()->write(json_encode(["error" => "Collectible not found"]));
      $response = $response->withStatus(404);
    }

    return $response;
  }
}
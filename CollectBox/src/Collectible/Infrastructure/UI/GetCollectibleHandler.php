<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\GetCollectibleByIdQuery;
use App\Collectible\Application\GetCollectibleByIdQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class GetCollectibleHandler implements RequestHandlerInterface
{
  public function __construct(private GetCollectibleByIdQueryHandler $getCollectibleByIdQueryHandler)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = (int) $request->getAttribute('id');

    $query = GetCollectibleByIdQuery::create($id);
    $result = $this->getCollectibleByIdQueryHandler->execute($query);

    if (!empty($result)) {
      $response->getBody()->write(json_encode($result));  
    } else {
      $response->getBody()->write(json_encode(["error" => "Collectible not found"], 404));
    }
    return $response;
  }
}
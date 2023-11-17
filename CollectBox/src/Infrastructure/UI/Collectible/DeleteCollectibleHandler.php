<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Collectible;

use App\Application\Collectible\DeleteCollectibleByIdCommand;
use App\Application\Collectible\DeleteCollectibleByIdCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class DeleteCollectibleHandler implements RequestHandlerInterface
{
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = $request->getAttribute('id');

    $query = new DeleteCollectibleByIdCommand($id);
    $queryHandler = new DeleteCollectibleByIdCommandHandler();

    $result = $queryHandler->execute($query);

    $response->getBody()->write(json_encode($result));
    return $response;
  }
}
<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\DeleteCollectibleByIdCommand;
use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class DeleteCollectibleHandler implements RequestHandlerInterface
{
  private const ID = "ID";

  public function __construct(private DeleteCollectibleByIdCommandHandler $deleteCollectibleByIdCommandHandler)
  {
  }
  
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = $request->getAttribute('id');

    $query = DeleteCollectibleByIdCommand::create($id);
    $result = $this->deleteCollectibleByIdCommandHandler->execute($query);

    $response->getBody()->write(json_encode([self::ID => $result->value()]));
    return $response;
  }
}
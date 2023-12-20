<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\DeleteCollectibleByIdCommand;
use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Shared\Domain\Exception\UuidInvalidException;
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
    $id = $request->getAttribute('id') ?? '';

    try {
      $query = DeleteCollectibleByIdCommand::create($id);
      $result = $this->deleteCollectibleByIdCommandHandler->execute($query);

      $response->getBody()->write(json_encode([self::ID => $result->value()]));
    } catch (UuidInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
      $response = $response->withStatus(500);
    } catch (CollectibleNotFoundException $e) {
      $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
      $response = $response->withStatus(404);
    }
    
    return $response;
  }
}
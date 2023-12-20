<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\PutCollectibleCommand;
use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Shared\Domain\Exception\NonEmptyStringInvalidException;
use App\Shared\Domain\Exception\UuidInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class PutCollectibleHandler implements RequestHandlerInterface
{
  public function __construct(private PutCollectibleCommandHandler $putCollectibleCommandHandler)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = $request->getAttribute("id") ?? '';
    $name = $request->getParsedBody()['name'] ?? '';
    $rarity = $request->getParsedBody()['rarity'] ?? '';

    try {
      $query = PutCollectibleCommand::create($id, $name, $rarity);
      $result = $this->putCollectibleCommandHandler->execute($query);
      
      if (!empty($result)) {
        $response->getBody()->write(json_encode($result->toArray()));  
      } else {
        //TODO: handle not found in command
        $response->getBody()->write(json_encode(["error" => "Collectible not found"]));
        $response = $response->withStatus(404);
      }
    } catch (NonEmptyStringInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => "Name or rarity missing"]));
      $response = $response->withStatus(500);
    } catch (UuidInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
      $response = $response->withStatus(500);
    }
    
    return $response;
  }
}
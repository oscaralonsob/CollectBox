<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\PutCollectibleCommand;
use App\Collectible\Application\PutCollectibleCommandHandler;
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
    $id = $request->getAttribute("id");
    $name = $request->getParsedBody()['name'];
    $rarity = $request->getParsedBody()['rarity'];

    //TODO: delegate responsibility to create
    if (empty($id) || empty($name) || empty($rarity)) {
      $response->getBody()->write(json_encode(["error" => "Id, name or rarity missing"]));
      $response = $response->withStatus(500);
    } else {
      $query = PutCollectibleCommand::create($id, $name, $rarity);
      $result = $this->putCollectibleCommandHandler->execute($query);
      
      if (!empty($result)) {
        $response->getBody()->write(json_encode($result->toArray()));  
      } else {
        $response->getBody()->write(json_encode(["error" => "Collectible not found"]));
        $response = $response->withStatus(404);
      }
    }
    
    return $response;
  }
}
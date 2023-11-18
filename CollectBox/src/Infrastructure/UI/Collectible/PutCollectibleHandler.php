<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Collectible;

use App\Application\Collectible\PutCollectibleCommand;
use App\Application\Collectible\PutCollectibleCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class PutCollectibleHandler implements RequestHandlerInterface
{

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $id = (int) $request->getAttribute("id");
    $name = $request->getParsedBody()['name'];
    $rarity = $request->getParsedBody()['rarity'];

    //TODO: delegate responsibility to create
    if (empty($id) || empty($name) || empty($rarity)) {
      $response->getBody()->write(json_encode(["error" => "Id, name or rarity missing"], 400));
    } else {
      $query = PutCollectibleCommand::create($id, $name, $rarity);
      $queryHandler = new PutCollectibleCommandHandler();
      $result = $queryHandler->execute($query);
      
      if (!empty($result)) {
        $response->getBody()->write(json_encode($result));  
      } else {
        $response->getBody()->write(json_encode(["error" => "Collectible not found"], 404));
      }
    }
    
    return $response;
  }
}
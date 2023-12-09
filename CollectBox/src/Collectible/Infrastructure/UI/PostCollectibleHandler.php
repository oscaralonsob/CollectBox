<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\PostCollectibleCommand;
use App\Collectible\Application\PostCollectibleCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class PostCollectibleHandler implements RequestHandlerInterface
{

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $name = $request->getParsedBody()['name'];
    $rarity = $request->getParsedBody()['rarity'];

    //TODO: delegate responsibility to create
    if (empty($name) || empty($rarity)) {
      $response->getBody()->write(json_encode(["error" => "Name or rarity missing"], 400));
    } else {
      $query = PostCollectibleCommand::create($name, $rarity);
      $queryHandler = new PostCollectibleCommandHandler();

      $result = $queryHandler->execute($query);
      $response->getBody()->write(json_encode($result->toArray()));
    }
    
    return $response;
  }
}
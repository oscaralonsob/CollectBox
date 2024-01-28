<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\PostCollectibleCommand;
use App\Collectible\Application\PostCollectibleCommandHandler;
use App\Shared\Domain\Exception\NonEmptyStringInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class PostCollectibleHandler implements RequestHandlerInterface
{
  public function __construct(private PostCollectibleCommandHandler $postCollectibleCommandHandler)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $name = $request->getParsedBody()['name'] ?? '';
    $url = $request->getParsedBody()['url'] ?? '';

    try {
      $query = PostCollectibleCommand::create($name, $url);
      $result = $this->postCollectibleCommandHandler->execute($query);
      $response->getBody()->write(json_encode($result->toArray()));
    } catch (NonEmptyStringInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => "Name or url missing"]));
      $response = $response->withStatus(500);
    }
    
    return $response;
  }
}
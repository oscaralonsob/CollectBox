<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\PutCollectibleCommand;
use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
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
    $url = $request->getParsedBody()['url'] ?? '';

    try {
      $query = PutCollectibleCommand::create($id, $name, $url);
      $result = $this->putCollectibleCommandHandler->execute($query);
      
      $response->getBody()->write(json_encode($result->toArray()));  
      
    } catch (NonEmptyStringInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => "Name or url missing"]));
      $response = $response->withStatus(500);
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
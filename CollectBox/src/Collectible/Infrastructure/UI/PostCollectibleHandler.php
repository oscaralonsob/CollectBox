<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\UI;

use App\Collectible\Application\PostCollectibleCommand;
use App\Collectible\Application\PostCollectibleCommandHandler;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Exception\CollectibleCodeInvalidException;
use App\Collectible\Domain\Exception\CollectibleNameInvalidException;
use App\Collectible\Domain\Exception\CollectibleUrlInvalidException;
use App\Shared\Domain\Exception\NonEmptyStringInvalidException;
use Exception;
use PharIo\Manifest\InvalidUrlException;
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
    $code = $request->getParsedBody()['code'] ?? '';
    $name = $request->getParsedBody()['name'] ?? '';
    $url = $request->getParsedBody()['url'] ?? '';

    try {
      $query = PostCollectibleCommand::create($code, $name, $url);
      $result = $this->postCollectibleCommandHandler->execute($query);
      $response->getBody()->write(json_encode($result->toArray()));
    } catch (CollectibleCodeInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
      $response = $response->withStatus(500);
    } catch (CollectibleNameInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
      $response = $response->withStatus(500);
    } catch (CollectibleUrlInvalidException $e) {
      $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
      $response = $response->withStatus(500);
    } catch (Exception $e) {
      $response->getBody()->write(json_encode(["error" => "Unknown error"]));
      $response = $response->withStatus(500);
    }
    
    return $response;
  }
}
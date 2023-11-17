<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Home;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class HomeHandler implements RequestHandlerInterface
{
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);
    $response->getBody()->write(json_encode(["msg" => "Hello"]));  

    return $response;
  }
}
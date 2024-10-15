<?php

declare(strict_types=1);

namespace App\User\Infrastructure\UI\Handler;

use App\User\Application\LoginCommand;
use App\User\Application\LoginCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class LoginHandler implements RequestHandlerInterface
{
  public function __construct(private LoginCommandHandler $loginCommandHandler)
  {
  }
  
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response(200);

    $userName = $request->getAttribute('userName');
    $password = $request->getAttribute('password');
    $query = LoginCommand::create($userName, $password);

    $result = $this->loginCommandHandler->execute($query);

    //TODO: Exception
    if (!is_null($result)) {
      $response->getBody()->write(json_encode($result->toArray()));  
    } else {
      $response->getBody()->write(json_encode(["error" => "User not found"]));
      $response = $response->withStatus(404);
    }
    
    return $response;
  }
}
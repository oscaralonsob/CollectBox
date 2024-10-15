<?php

declare(strict_types=1);

namespace Tests\Unit\User\Infrastructure\UI\Handler;

use App\User\Application\LoginCommandHandler;
use App\User\Infrastructure\UI\Handler\LoginHandler;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Infrastructure\TestCase\BaseTestCase;
use Tests\Infrastructure\User\Domain\Aggregate\UserStub;

class LoginHandlerTest extends BaseTestCase
{
  private ServerRequestInterface|MockObject $request;
  private LoginCommandHandler|MockObject $loginCommandHandler;
  private LoginHandler $loginHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->loginCommandHandler = $this->createMock(LoginCommandHandler::class);
    $this->loginHandler = new LoginHandler($this->loginCommandHandler);
  }

  public function testHandlerReturn200WhenDoesExist(): void
  {
    $user = UserStub::random();

    $this->request->method('getAttribute')->willReturn($user->userName()->value(), $user->password()->value());
    $this->loginCommandHandler->method('execute')->willReturn($user);

    $response = $this->loginHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectibleWhenDoesExist(): void
  {
    $user = UserStub::random();

    $this->request->method('getAttribute')->willReturn($user->userName()->value(), $user->password()->value());
    $this->loginCommandHandler->method('execute')->willReturn($user);

    $response = $this->loginHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals($user->toArray(), json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn404WhenDoesNotExist(): void
  {
    $user = UserStub::random();

    $this->request->method('getAttribute')->willReturn($user->userName()->value(), $user->password()->value());
    $this->loginCommandHandler->method('execute')->willReturn(null);//TODO: Exception

    $response = $this->loginHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHandlerReturnNoCollectibleWhenDoesNotExist(): void
  {
    $user = UserStub::random();

    $this->request->method('getAttribute')->willReturn($user->userName()->value(), $user->password()->value());
    $this->loginCommandHandler->method('execute')->willReturn(null);//TODO: Exception

    $response = $this->loginHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(["error" => "User not found"], json_decode($response->getBody()->getContents(), true));
  }
}
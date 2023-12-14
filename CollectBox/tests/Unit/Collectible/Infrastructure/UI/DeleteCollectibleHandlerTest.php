<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use App\Collectible\Infrastructure\UI\DeleteCollectibleHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCollectibleHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private DeleteCollectibleByIdCommandHandler|MockObject $deleteCollectibleByIdCommandHandler;
  private DeleteCollectibleHandler $deleteCollectibleHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->deleteCollectibleByIdCommandHandler = $this->createMock(DeleteCollectibleByIdCommandHandler::class);
    $this->deleteCollectibleHandler = new DeleteCollectibleHandler($this->deleteCollectibleByIdCommandHandler);
  }

  public function testHandlerReturnId(): void
  {
    $this->request->method('getAttribute')->willReturn(1);
    $this->deleteCollectibleByIdCommandHandler->method('execute')->willReturn(1);

    $response = $this->deleteCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(["ID" => 1], json_decode($response->getBody()->getContents(), true));
  }
}
<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Infrastructure\UI\DeleteCollectibleHandler;
use App\Shared\Domain\Exception\UuidInvalidException;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
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
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->deleteCollectibleByIdCommandHandler->method('execute')->willReturn($collectible->id());

    $response = $this->deleteCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(["ID" => $collectible->id()->value()], json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn404WhenDoesNotExist(): void
  {    
    $collectible = CollectibleMother::createRandom();
    $this->deleteCollectibleByIdCommandHandler->method('execute')->willThrowException(CollectibleNotFoundException::create($collectible->id()));

    $response = $this->deleteCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenInvalidId(): void
  {
    $this->deleteCollectibleByIdCommandHandler->method('execute')->willThrowException(UuidInvalidException::create(""));

    $response = $this->deleteCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }
}
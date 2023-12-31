<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\GetCollectibleByIdQueryHandler;
use App\Collectible\Infrastructure\UI\GetCollectibleHandler;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GetCollectibleHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private GetCollectibleByIdQueryHandler|MockObject $getCollectibleByIdQueryHandler;
  private GetCollectibleHandler $getCollectibleHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->getCollectibleByIdQueryHandler = $this->createMock(GetCollectibleByIdQueryHandler::class);
    $this->getCollectibleHandler = new GetCollectibleHandler($this->getCollectibleByIdQueryHandler);
  }

  public function testHandlerReturn200WhenDoesExist(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->getCollectibleByIdQueryHandler->method('execute')->willReturn($collectible);

    $response = $this->getCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectibleWhenDoesExist(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->getCollectibleByIdQueryHandler->method('execute')->willReturn($collectible);

    $response = $this->getCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals($collectible->toArray(), json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn404WhenDoesNotExist(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->getCollectibleByIdQueryHandler->method('execute')->willReturn(null);

    $response = $this->getCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHandlerReturnNoCollectibleWhenDoesNotExist(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->getCollectibleByIdQueryHandler->method('execute')->willReturn(null);

    $response = $this->getCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(["error" => "Collectible not found"], json_decode($response->getBody()->getContents(), true));
  }
}
<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI\Handler;

use App\Collectible\Application\GetCollectiblesQueryHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Infrastructure\UI\Handler\GetCollectiblesHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleCollectionStub;

class GetCollectiblesHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private GetCollectiblesQueryHandler|MockObject $getCollectiblesQueryHandler;
  private GetCollectiblesHandler $getCollectiblesHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->getCollectiblesQueryHandler = $this->createMock(GetCollectiblesQueryHandler::class);
    $this->getCollectiblesHandler = new GetCollectiblesHandler($this->getCollectiblesQueryHandler);
  }

  public function testHandlerReturn200(): void
  {
    $collectibles = CollectibleCollectionStub::random();

    $this->getCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->getCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturn200WhenEmpty(): void
  {
    $collectibles = CollectibleCollectionStub::empty();

    $this->getCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->getCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectibles(): void
  {
    $collectibles = CollectibleCollectionStub::random();

    $this->getCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->getCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(
      array_map(
        static function (Collectible $collectible) {
          return $collectible->toArray();
        },
        $collectibles->toArray()
    ), json_decode($response->getBody()->getContents(), true));
  }
}
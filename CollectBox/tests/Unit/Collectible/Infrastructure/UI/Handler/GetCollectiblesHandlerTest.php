<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI\Handler;

use App\Collectible\Application\SearchCollectiblesQueryHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Infrastructure\UI\Handler\GetCollectiblesHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleCollectionStub;

class GetCollectiblesHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private SearchCollectiblesQueryHandler|MockObject $searchCollectiblesQueryHandler;
  private GetCollectiblesHandler $searchCollectiblesHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->searchCollectiblesQueryHandler = $this->createMock(SearchCollectiblesQueryHandler::class);
    $this->searchCollectiblesHandler = new GetCollectiblesHandler($this->searchCollectiblesQueryHandler);
  }

  public function testHandlerReturn200(): void
  {
    $collectibles = CollectibleCollectionStub::random();

    $this->searchCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->searchCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturn200WhenEmpty(): void
  {
    $collectibles = CollectibleCollectionStub::empty();

    $this->searchCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->searchCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectibles(): void
  {
    $collectibles = CollectibleCollectionStub::random();

    $this->searchCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->searchCollectiblesHandler->handle($this->request);
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
<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\GetCollectiblesQueryHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Infrastructure\UI\GetCollectiblesHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

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
    $collectibles = [Collectible::create(1, 'testName', 'testRarity'), Collectible::create(2, 'testName2', 'testRarity2')];
    $this->request->method('getAttribute')->willReturn(1);
    $this->getCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->getCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturn200WhenEmpty(): void
  {
    $collectibles = [];
    $this->request->method('getAttribute')->willReturn(1);
    $this->getCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->getCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectibles(): void
  {
    $collectibles = [Collectible::create(1, 'testName', 'testRarity'), Collectible::create(2, 'testName2', 'testRarity2')];
    $this->request->method('getAttribute')->willReturn(1);
    $this->getCollectiblesQueryHandler->method('execute')->willReturn($collectibles);

    $response = $this->getCollectiblesHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(
      array_map(
        static function (Collectible $collectible) {
          return $collectible->toArray();
        },
        $collectibles
    ), json_decode($response->getBody()->getContents(), true));
  }
}
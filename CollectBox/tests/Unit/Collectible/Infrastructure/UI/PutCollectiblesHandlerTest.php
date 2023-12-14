<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Infrastructure\UI\PutCollectibleHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class PutCollectiblesHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private PutCollectibleCommandHandler|MockObject $putCollectibleCommandHandler;
  private PutCollectibleHandler $putCollectibleHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->putCollectibleCommandHandler = $this->createMock(PutCollectibleCommandHandler::class);
    $this->putCollectibleHandler = new PutCollectibleHandler($this->putCollectibleCommandHandler);
  }

  public function testHandlerReturn200(): void
  {
    $collectible = Collectible::create(1, 'testName', 'testRarity');
    $this->request->method('getAttribute')->willReturn(1);
    $this->request->method('getParsedBody')->willReturn([
      'name' => 'testName',
      'rarity' => 'testRarity',
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectible(): void
  {
    $collectible = Collectible::create(1, 'testName', 'testRarity');
    $this->request->method('getAttribute')->willReturn(1);
    $this->request->method('getParsedBody')->willReturn([
      'name' => 'testName',
      'rarity' => 'testRarity',
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals($collectible->toArray(), json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn404WhenDoesNotExist(): void
  {
    $this->request->method('getAttribute')->willReturn(1);
    $this->request->method('getParsedBody')->willReturn([
      'name' => 'testName',
      'rarity' => 'testRarity',
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn(null);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoIdProvided(): void
  {
    $this->request->method('getParsedBody')->willReturn([
      'name' => 'testName',
      'rarity' => '',
    ]);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoNameProvided(): void
  {
    $this->request->method('getAttribute')->willReturn(1);
    $this->request->method('getParsedBody')->willReturn([
      'name' => '',
      'rarity' => 'testRarity',
    ]);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoRarityProvided(): void
  {
    $this->request->method('getAttribute')->willReturn(1);
    $this->request->method('getParsedBody')->willReturn([
      'name' => 'testName',
      'rarity' => '',
    ]);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }
}
<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Collectible\Infrastructure\UI\PutCollectibleHandler;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class PutCollectibleHandlerTest extends TestCase
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
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => $collectible->rarity()->value(),
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectible(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => $collectible->rarity()->value(),
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals($collectible->toArray(), json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn404WhenDoesNotExist(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => $collectible->rarity()->value(),
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn(null);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoIdProvided(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => '',
    ]);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoNameProvided(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => '',
      'rarity' => $collectible->rarity()->value(),
    ]);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoRarityProvided(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => '',
    ]);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }
}
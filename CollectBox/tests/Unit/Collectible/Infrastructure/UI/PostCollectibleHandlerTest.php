<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\PostCollectibleCommandHandler;
use App\Collectible\Infrastructure\UI\PostCollectibleHandler;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class PostCollectibleHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private PostCollectibleCommandHandler|MockObject $postCollectibleCommandHandler;
  private PostCollectibleHandler $postCollectibleHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->postCollectibleCommandHandler = $this->createMock(PostCollectibleCommandHandler::class);
    $this->postCollectibleHandler = new PostCollectibleHandler($this->postCollectibleCommandHandler);
  }

  public function testHandlerReturn200(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => $collectible->rarity()->value(),
    ]);
    $this->postCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->postCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectible(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => $collectible->rarity()->value(),
    ]);
    $this->postCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->postCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals($collectible->toArray(), json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn500WhenNoNameProvided(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getParsedBody')->willReturn([
      'name' => '',
      'rarity' => $collectible->rarity()->value(),
    ]);

    $response = $this->postCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenNoRarityProvided(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'rarity' => '',
    ]);

    $response = $this->postCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }
}
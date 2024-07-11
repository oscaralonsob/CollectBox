<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\PostCollectibleCommand;
use App\Collectible\Application\PostCollectibleCommandHandler;
use App\Collectible\Domain\Repository\CollectibleRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Infrastructure\Collectible\Domain\Aggregate\CollectibleStub;

class PostCollectibleCommandHandlerTest extends TestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private PostCollectibleCommandHandler $postCollectibleCommandHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->postCollectibleCommandHandler = new PostCollectibleCommandHandler($this->collectibleRepository);
  }

  public function testSaveIsCalled(): void
  {
    $this->collectibleRepository->expects($this->once())->method('save');

    $this->postCollectibleCommandHandler->execute(PostCollectibleCommand::create("B01-001R", "testName", "https://wiki.serenesforest.net/index.php/Collectible-1"));
  }

  public function testCollectibleIsReturned(): void
  {
    $collectible = CollectibleStub::random();
    $this->collectibleRepository->method('save')->willReturn($collectible);

    $result = $this->postCollectibleCommandHandler->execute(PostCollectibleCommand::create($collectible->code()->value(), $collectible->name()->value(), $collectible->url()->value()));
    
    $this->assertEquals($collectible, $result);
  }
}
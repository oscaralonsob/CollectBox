<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\PostCollectibleCommand;
use App\Collectible\Application\PostCollectibleCommandHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

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

    $this->postCollectibleCommandHandler->execute(PostCollectibleCommand::create("testName", "testRarity"));
  }

  public function testCollectibleIsReturned(): void
  {
    $collectible = Collectible::create(
      DomainId::createRandom(), 
      "testName", 
      "testRarity"
    );
    $this->collectibleRepository->method('save')->willReturn($collectible);

    $result = $this->postCollectibleCommandHandler->execute(PostCollectibleCommand::create($collectible->name(), $collectible->rarity()));
    
    $this->assertEquals($collectible, $result);
  }
}
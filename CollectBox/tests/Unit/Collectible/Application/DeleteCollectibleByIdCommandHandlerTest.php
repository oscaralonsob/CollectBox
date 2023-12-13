<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\DeleteCollectibleByIdCommand;
use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteCollectibleByIdCommandHandlerTest extends TestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private DeleteCollectibleByIdCommandHandler $deleteCollectibleByIdCommandHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->deleteCollectibleByIdCommandHandler = new DeleteCollectibleByIdCommandHandler($this->collectibleRepository);
  }

  public function testDeleteIsCalled(): void
  {
    $collectible = Collectible::create(1, "testName", "testRarity");
    $this->collectibleRepository->expects($this->once())->method('delete')->willReturn($collectible->id());

    $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()));
  }

  public function testIdIsReturned(): void
  {
    $collectible = Collectible::create(1, "testName", "testRarity");
    $this->collectibleRepository->method('delete')->willReturn($collectible->id());

    $result = $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()));

    $this->assertEquals($collectible->id(), $result);
  }
}
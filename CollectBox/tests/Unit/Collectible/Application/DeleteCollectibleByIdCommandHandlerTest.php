<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\DeleteCollectibleByIdCommand;
use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use App\Collectible\Domain\Repository\CollectibleRepository;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
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
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->expects($this->once())->method('delete')->willReturn($collectible->id());

    $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()->value()));
  }

  public function testIdIsReturned(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->method('delete')->willReturn($collectible->id());

    $result = $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()->value()));

    $this->assertEquals($collectible->id(), $result);
  }
}
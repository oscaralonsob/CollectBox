<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\DeleteCollectibleByIdCommand;
use App\Collectible\Application\DeleteCollectibleByIdCommandHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
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
    $this->collectibleRepository->method('findById')->willReturn($collectible);
    $this->collectibleRepository->expects($this->once())->method('delete')->willReturn($collectible->id());

    $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()->value()));
  }

  public function testIdIsReturned(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->method('findById')->willReturn($collectible);
    $this->collectibleRepository->method('delete')->willReturn($collectible->id());

    $result = $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()->value()));

    $this->assertEquals($collectible->id(), $result);
  }

  public function testCollectibleNotFoundExceptionIsThrow(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->expectException(CollectibleNotFoundException::class);
    $this->collectibleRepository->method('findById')->willReturn(null);

    $this->deleteCollectibleByIdCommandHandler->execute(DeleteCollectibleByIdCommand::create($collectible->id()->value()));
  }
}
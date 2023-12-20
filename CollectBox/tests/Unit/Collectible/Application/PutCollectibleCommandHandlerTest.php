<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\PutCollectibleCommand;
use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Repository\CollectibleRepository;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PutCollectibleCommandHandlerTest extends TestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private PutCollectibleCommandHandler $putCollectibleCommandHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->putCollectibleCommandHandler = new PutCollectibleCommandHandler($this->collectibleRepository);
  }

  public function testSaveIsCalled(): void
  {    
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->method('findById')->willReturn($collectible);
    $this->collectibleRepository->expects($this->once())->method('save')->willReturn($collectible);

    $this->putCollectibleCommandHandler->execute(PutCollectibleCommand::create($collectible->id()->value(), $collectible->name()->value(), $collectible->rarity()->value()));
  }

  public function testCollectibleIsReturned(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->method('findById')->willReturn($collectible);
    $this->collectibleRepository->method('save')->willReturn($collectible);

    $result = $this->putCollectibleCommandHandler->execute(PutCollectibleCommand::create($collectible->id()->value(), $collectible->name()->value(), $collectible->rarity()->value()));
    
    $this->assertEquals($collectible, $result);
  }

  public function testCollectibleNotFoundExceptionIsThrow(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->expectException(CollectibleNotFoundException::class);
    $this->collectibleRepository->method('findById')->willReturn(null);

    $this->putCollectibleCommandHandler->execute(PutCollectibleCommand::create($collectible->id()->value(), $collectible->name()->value(), $collectible->rarity()->value()));
  }
}
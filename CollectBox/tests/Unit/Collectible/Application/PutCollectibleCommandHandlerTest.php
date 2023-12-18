<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\PutCollectibleCommand;
use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
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
    $collectible = Collectible::create(
      DomainId::createRandom(), 
      NonEmptyString::create("testName"),
      NonEmptyString::create("testRarity")
    );
    $this->collectibleRepository->expects($this->once())->method('save')->willReturn($collectible);

    $this->putCollectibleCommandHandler->execute(PutCollectibleCommand::create($collectible->id()->value(), $collectible->name()->value(), $collectible->rarity()->value()));
  }

  public function testCollectibleIsReturned(): void
  {
    
    $collectible = Collectible::create(
      DomainId::createRandom(), 
      NonEmptyString::create("testName"), 
      NonEmptyString::create("testRarity")
    );
    $this->collectibleRepository->method('save')->willReturn($collectible);

    $result = $this->putCollectibleCommandHandler->execute(PutCollectibleCommand::create($collectible->id()->value(), $collectible->name()->value(), $collectible->rarity()->value()));
    
    $this->assertEquals($collectible, $result);
  }
}
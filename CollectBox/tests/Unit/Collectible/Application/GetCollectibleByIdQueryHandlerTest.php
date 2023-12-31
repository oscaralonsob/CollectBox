<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\GetCollectibleByIdQuery;
use App\Collectible\Application\GetCollectibleByIdQueryHandler;
use App\Collectible\Domain\Repository\CollectibleRepository;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCollectibleByIdQueryHandlerTest extends TestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private GetCollectibleByIdQueryHandler $getCollectibleByIdQueryHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->getCollectibleByIdQueryHandler = new GetCollectibleByIdQueryHandler($this->collectibleRepository);
  }

  public function testFindByIdIsCalled(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->expects($this->once())->method('findById')->willReturn($collectible);

    $this->getCollectibleByIdQueryHandler->execute(GetCollectibleByIdQuery::create($collectible->id()->value()));
  }

  public function testACollectibleIsReturned(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->method('findById')->willReturn($collectible);

    $result = $this->getCollectibleByIdQueryHandler->execute(GetCollectibleByIdQuery::create($collectible->id()->value()));

    $this->assertEquals($collectible, $result);
  }

  public function testNoCollectibleIsReturned(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleRepository->method('findById')->willReturn(null);

    $result = $this->getCollectibleByIdQueryHandler->execute(GetCollectibleByIdQuery::create($collectible->id()->value()));

    $this->assertNull($result);
  }
}
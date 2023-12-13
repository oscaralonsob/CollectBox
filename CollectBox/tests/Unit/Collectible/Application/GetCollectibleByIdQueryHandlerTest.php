<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\GetCollectibleByIdQuery;
use App\Collectible\Application\GetCollectibleByIdQueryHandler;
use App\Collectible\Application\GetCollectiblesQuery;
use App\Collectible\Application\GetCollectiblesQueryHandler;
use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
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

  public function testACollectionIsReturned(): void
  {
    $collectible = Collectible::create(1, "testName", "testRarity");
    $this->collectibleRepository->method('findById')->willReturn($collectible);

    $result = $this->getCollectibleByIdQueryHandler->execute(GetCollectibleByIdQuery::create($collectible->id()));

    $this->assertEquals($collectible, $result);
  }

  public function testNoCollectionIsReturned(): void
  {
    $this->collectibleRepository->method('findById')->willReturn(null);

    $result = $this->getCollectibleByIdQueryHandler->execute(GetCollectibleByIdQuery::create(1));

    $this->assertNull($result);
  }
}